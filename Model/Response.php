<?php

namespace Magestio\Redsys\Model;

/**
 * Class Response
 * @package Magestio\Redsys\Model
 */
class Response
{

    protected $responses = [
        '101' => 'Tarjeta caducada',
        '102' => 'Tarjeta en excepcion transitoria o bajo sospecha de fraude',
        '104' => 'Operacion no permitida para esa tarjeta o terminal',
        '106' => 'Intentos de PIN excedidos',
        '116' => 'Disponible insuficiente',
        '118' => 'Tarjeta no registrada',
        '125' => 'Tarjeta no efectiva.',
        '129' => 'Codigo de seguridad (CVV2/CVC2) incorrecto',
        '180' => 'Tarjeta ajena al servicio',
        '184' => 'Error en la autenticacion del titular',
        '190' => 'Denegacion sin especificar Motivo',
        '191' => 'Fecha de caducidad erronea',
        '201' => 'Transacción denegada porque la fecha de caducidad de la tarjeta que se ha informado en el pago, es anterior a la actualmente vigente',
        '202' => 'Tarjeta en excepcion transitoria o bajo sospecha de fraude con retirada de tarjeta',
        '204' => 'Operación no permitida para ese tipo de tarjeta',
        '207' => 'El banco emisor no permite una autorización automática. Es necesario contactar telefónicamente con su centro autorizador para obtener una aprobación manual',
        '208' => 'Es erróneo el código CVV2/CVC2 informado por el comprador',
        '209' => 'Tarjeta bloqueada por el banco emisor debido a que el titular le ha manifestado que le ha sido robada o perdida',
        '290' => 'Transacción denegada por el banco emisor pero sin que este dé detalles acerca del motivo',
        '904' => 'Comercio no registrado en FUC.',
        '909' => 'Error de sistema.',
        '913' => 'Pedido repetido.',
        '930' => 'Realizado por Transferencia bancaria / Realizado por Domiciliacion bancaria',
        '944' => 'Sesión Incorrecta.',
        '950' => 'Operación de devolución no permitida.',
        '9064' => 'Número de posiciones de la tarjeta incorrecto.',
        '9078' => 'No existe método de pago válido para esa tarjeta.',
        '9093' => 'Tarjeta no existente.',
        '9094' => 'Rechazo servidores internacionales.',
        '9104' => 'Comercio con “titular seguro” y titular sin clave de compra segura.',
        '9218' => 'El comercio no permite op. seguras por entrada /operaciones.',
        '9253' => 'Tarjeta no cumple el check-digit.',
        '9256' => 'El comercio no puede realizar preautorizaciones.',
        '9257' => 'Esta tarjeta no permite operativa de preautorizaciones.',
        '9261' => 'Emisor no disponible',
        '912' => 'Emisor no disponible',
        '9912' => 'Emisor no disponible',
        '9913' => 'Error en la confirmación que el comercio envía al TPV Virtual (solo aplicable en la opción de sincronización SOAP).',
        '9914' => 'Confirmación “KO” del comercio (solo aplicable en la opción de sincronización SOAP).',
        '9915' => 'A petición del usuario se ha cancelado el pago.',
        '9928' => 'Anulación de autorización en diferido realizada por el SIS (proceso batch).',
        '9929' => 'Anulación de autorización en diferido realizada por el comercio.',
        '9997' => 'Se está procesando otra transacción en SIS con la misma tarjeta.',
        '9998' => 'Operación en proceso de solicitud de datos de tarjeta.',
        '9999' => 'Operación que ha sido redirigida al emisor a autenticar.',
    ];

    /**
     * @param $responseCode
     * @return string
     */
    public function messageResponse($responseCode)
    {
        if (isset($this->responses[$responseCode])) {
            return $this->responses[$responseCode];
        }
        return 'Transaccion denegada codigo:'.$responseCode;

    }

}