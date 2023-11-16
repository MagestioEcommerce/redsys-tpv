# Extension TPV Redsys para Magento 2

<p>
<a href="https://magestio.com/"><img src="https://magestio.com/wp-content/uploads/magestio-logo@4x-8.png" align="left" width="120" height="25" ></a>
</p>

### Características

* Desarrollado con la nueva API Gateway Payment de Magento 2 [Magento 2 Payment Gateway API](https://devdocs.magento.com/guides/v2.2/payments-integrations/payment-gateway/payment-gateway-intro.html)
* Permite a los clientes pagar con tarjetas de crédito o débito
* Permite a los clientes pagar con Bizum
* Pagos seguros a través de la Pasarela de Pago de Redsys
* Los clientes pueden cambiar de método de pago en caso de fallo
* Recupera el carrito en caso de fallo
* Crea facturas automáticamente
* Envía facturas automáticamente al cliente
* Compatible with HTTPS/SSL
* La Pasarela de Pago de Redsys utilizara el mismo idioma que la tienda
* Compatible con la funcionalidad de redsys de redirección automática a la paǵina de pedido realizado con éxito de Magento
  * Para que esto funcione, en la configuración del tpv Redsys, en el apartado Comercio asignar el campo "Parámetros en las URLs" a "Si, sin mostrar recibo Redsys".
* Múltiples monedas
* Entornos de Producción y Test
* Multi tienda


### Instalación

#### Utilizando composer

```
    composer require magestio/magento-2-redsys
```

#### Por copia directa de archivos

* Descarga la extensión
* Descomprime el archivo
* Crea el directorio app/code/Magestio/Redsys  
* Copia el contenido del archivo a esa carpeta


### Habilitar extensión

```
php bin/magento module:enable Magestio_Redsys
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush
php bin/magento setup:static-content:deploy
```

### Requisitos

* Compatible with Magento 2.3.+ y 2.4.+

### Soporte técnico

* Web: [Agencia Ecommerce Magestio](https://magestio.com/)
