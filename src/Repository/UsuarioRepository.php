<?php

namespace App\Repository;

use App\Classes\Utilidades;
use App\Entity\Jugador;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    /**
     * @param $filtros
     * @return mixed
     */
    public function lista($filtros)
    {
        $em = $this->getEntityManager();
        $usuario = $filtros['usuario']?? false;

        $qb = $em->createQueryBuilder();
        $qb->from(Usuario::class, "u")
            ->select("u.codigoUsuarioPk as codigo_usuario")
            ->addSelect("u.codigoJugadorFk as codigo_jugador")
            ->addSelect("u.usuario")
            ->addSelect("j.nombreCorto as jugador_nombre_corto")
            ->leftJoin("u.jugadorRel", "j");

        # Filtros
        if($usuario !== false) {
            $qb->andWhere("u.usuario = '{$usuario}'");
        }

        return $qb->getQuery()->getResult();
    }

    public function validar($datos) {
        $em = $this->getEntityManager();
        $usuario = $datos['usuario']?? '';
        $imei = $datos['imei']?? '';
        if($usuario && $imei) {
            $arUsuario = $this->usuarioIngreso($usuario, $imei);
            if($arUsuario->getEstadoVerificado()) {
                if($imei == $arUsuario->getImei()) {
                    return [
                        "verificado" => true,
                        "codigo_usuario" => $arUsuario->getCodigoUsuarioPk(),
                    ];
                } else {
                    $codigo = $this->generarCodigo(4);
                    $arUsuario->setCodigoVerificacion($codigo);
                    $arUsuario->setImei($imei);
                    $arUsuario->setEstadoVerificado(0);
                    $em->persist($arUsuario);
                    $em->flush();
                    $this->enviarCodigo($usuario, $codigo);
                    return [
                        "verificado" => false
                    ];
                }
            } else {
                $codigo = $this->generarCodigo(4);
                $arUsuario->setCodigoVerificacion($codigo);
                $arUsuario->setImei($imei);
                $em->persist($arUsuario);
                $em->flush();
                $this->enviarCodigo($usuario, $codigo);
                return [
                    "verificado" => false
                ];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    private function usuarioIngreso($usuario, $imei) {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->findOneBy(['usuario' => $usuario]);
        if(!$arUsuario) {
            $arJugador = new Jugador();
            $em->persist($arJugador);
            $em->flush();

            $arUsuario = new Usuario();
            $arUsuario->setCodigoUsuarioPk($arJugador->getCodigoJugadorPk());
            $arUsuario->setUsuario($usuario);
            $arUsuario->setJugadorRel($arJugador);
            $arUsuario->setImei($imei);
            $em->persist($arUsuario);
            $em->flush();
        }
        return $arUsuario;
    }

    private function generarCodigo($longitud) {
        $key = '';
        $pattern = '1234567890';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
        return $key;
    }

    private function enviarCodigo($telefono, $codigo) {
        $basic  = new \Nexmo\Client\Credentials\Basic('68f3f797', 'ZwXadzBwzVmV1mBa');
        $client = new \Nexmo\Client($basic);
        $message = $client->message()->send([
            'to' => "57{$telefono}",
            'from' => 'jakoservicio',
            'text' => "jako-{$codigo}"
        ]);
    }

    public function verificar($datos) {
        $em = $this->getEntityManager();
        $usuario = $datos['usuario']?? '';
        $imei = $datos['imei']?? '';
        $codigo = $datos['codigo']?? '';
        if($usuario && $imei && $codigo) {
            $arUsuario = $em->getRepository(Usuario::class)->findOneBy(['usuario' => $usuario]);
            if($arUsuario->getCodigoVerificacion() == $codigo && $arUsuario->getImei() == $imei) {
                $arUsuario->setEstadoVerificado(1);
                $em->persist($arUsuario);
                $em->flush();
                return [
                    'verificado' => true,
                    'codigo_usuario' => $arUsuario->getCodigoUsuarioPk(),
                ];
            } else {
                return false;
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function informacionUsuario($datos) {
        $codigoUsuario = $datos['codigo_usuario']?? '0';
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario && $arUsuario instanceof  Usuario) {
            $arJugador = $arUsuario->getJugadorRel();
            return [
                'identificacion'    => $arJugador->getIdentificacion(),
                'nombre'            => $arJugador->getNombre(),
                'nombre_corto'      => $arJugador->getNombreCorto(),
                'apellido'          => $arJugador->getApellido(),
                'correo'            => $arJugador->getCorreo(),
                'seudonimo'         => $arJugador->getSeudonimo(),
            ];
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function guardarPseudonimo($datos) {
        $em = $this->getEntityManager();
        $codigoUsuario = $datos['codigo_usuario']?? 0;
        $seudonimo = $datos['seudonimo']?? '';
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        if($arUsuario && $arUsuario instanceof Usuario && $seudonimo) {
            $arJugador = $arUsuario->getJugadorRel();
            $qb = $em->createQueryBuilder()->from(Jugador::class, "j")
                    ->select("j")
                    ->where("j.seudonimo = '{$seudonimo}'")
                    ->andWhere("j.codigoJugadorPk <> '{$arJugador->getCodigoJugadorPk()}'")
                    ->setMaxResults(1);
            $arrExistente = $qb->getQuery()->getResult();
            if($arrExistente) {
                return [
                    'validacion' => Utilidades::validacion(9),
                ];
            } else {

                $arJugador->setSeudonimo($seudonimo);
                $em->persist($arJugador);
                $em->flush($arJugador);
                return true;
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }
}
