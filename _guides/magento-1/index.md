---
layout: guide
title: Magento 1 Implementation Guide
summary: This document provides instructions for completing the technical tasks associated with configuring a Magento 1 instance to integrate with Rivet’s e-commerce functionality and adding Rivet functionality to your Magento site.
---
This document provides instructions for completing the technical tasks associated with configuring a Magento 1 instance to integrate with Rivet’s e-commerce functionality and adding Rivet functionality to your Magento site. This guide supplements the [Rivet Implementation Guide](/guides/implementation/).

## Configure Magento
This section provides instructions for completing the technical tasks associated with configuring a Magento 1 instance to integrate with Rivet’s e-commerce functionality.

The integration process involves the following tasks:
- Create a SOAP/XML-RPC role for the Rivet integration to use.
- Assign resource access to the Rivet role.
- Create a user for the Rivet integration to use.
- Assign the Rivet role to the Rivet user.
- Communicate the Rivet user’s API Key to Rivet Customer Success.

### Create SOAP/XML-RPC Role

It is best to create a separate SOAP/XML-RPC role for the Rivet integration. Rivet requires access to certain resources that you will assign to the role. Creating a distinct role for Rivet isolates the needs of Rivet from any other roles in your Magento instance.

{% include callout.html type="info" title="Note" message="The name of the role does not affect the Rivet integration." %}

### Assign Resources

The Rivet Magento 1 integration requires access to the following resources. Please assign access to these resources to the Rivet role.

- Catalog
  - Product
    - Product downloadable links
      - List
    - Retrieve products data
    - Product Attributes
      - Get full information about attribute with list of options
      - Attribute Sets
        - List
      - Get list of possible attribute types
      - Retrieve attribute data
    - Link (Related, Up sell, Cross sell)
    - Product Images
    - Tag
      - List
    - Custom options
      - List
      - Option values
        - List
  - Category
    - Retrieve category data
    - Retrieve categories tree
    - Assigned Products
- Sales
  - Order
    - Order credit memo
      - Retrieve credit memo list
      - Retrieve credit memo info
      - Cancel
      - Comments
      - Create
    - Order invoice
      - Cancel
      - Retrieve invoice info
      - Void
      - Capture
      - Comments
      - Create
    - Order shipments
      - Send shipment info
      - Retrieve shipment info
      - Tracking
      - Comments
      - Create
    - Retrieve orders info
    - Change status, add comments
- Catalog Inventory
  - Retrieve stock data

### Create SOAP/XML-RPC User

It is best to create a SOAP/XML-RPC user for the Rivet integration. Creating a distinct user for Rivet allows you to manage Rivet’s access apart from any other users.

When you create the Rivet user, please ensure you create and set an API Key. The API Key allows Rivet’s system to authenticate to your Magento instance.

{% include callout.html type="danger" title="Important" message="Make sure to save the API Key elsewhere as you will not be able to get it from Magento after you save the Rivet user." %}

### Assign Role to User

For the Rivet user to have access to the appropriate Magento resources you need to assign the role you created earlier to the Rivet user.

### Communicate the Rivet users Name and API Key

Send [Rivet Customer Success](mailto:support@rivet.works) the Name and API key that you saved when you created the Rivet user earlier.

## Add Rivet to your site
Magento uses theme templates for customizing the store appearance and layout. You need to edit the template files directly in the file system. You can also edit the files remotely, upload, and overwrite the existing files. This section supplements the [Rivet Implementation Guide](/guides/implementation/).

The following sections show examples of adding conversion tracking to your order success page and a product-specific display to a product detail page.

### Conversion Tracker

Add the following to the order confirmation template at `/app/design/frontend/<your-package-name>/default/template/checkout/success.phtml`:

```php
<?php
    $order = Mage::getModel('sales/order')->load(Mage::getSingleton('checkout/session')->getLastOrderId());
    $customerId = $order->getCustomerId();
    $orderId = $order->getId();
    $cartTotal = round($order->getSubtotal(),2);
    $products = $order->getAllItems();
?>

<script type="text/javascript" src="//webapp.rivet.works/conversion.min.js"></script>
<script>rivet.config({
    "conversionKey": "_CustomerConversionCode_",
    "md": {
        "customerID": "<?php echo $customerId ?>",
        "orderID": "<?php echo $orderId ?>",
        "cartTotal": "<?php echo $cartTotal ?>",
        "products": [
            <?php foreach ($products as $product){
                    echo "{productID:'" . $product->getProductId() . "', unitPrice:'" . round($product->getPrice(),2) . "', quantity:'" . round($product->getQtyOrdered()) . "', description:'" . $product->getName() . "'},";
                }
            ?>
        ]
  }
});</script>

```

### Product Detail Page

Add the following code to the PDP template at `/app/design/frontend/<your-package-name>/default/template/catalog/product/view.phtml`.
You can find "_your filmstrip’s display key_" by logging into your Rivet Works account and clicking settings under your product display.

```html
                <div style="clear: both;" id="rvt-embed-1"> </div>

<script type="text/javascript" src="//webapp.rivet.works/rivet.min.js"></script>

<script> rivet.config ({
        "embeds": { "_your filmstrip’s display key_": "rvt-embed-1" },
        "pageContext": {
                "tags": {
                        "productId": "<*?php echo $this->getProduct()->getData('sku'); ?>*"
                }
        }
}); </script>
```
### Gallery Page

Add the following code to your desired location for a customer gallery.

```html
<div id="rvt-embed-1"></div>
<script type="text/javascript" src="//webapp.rivet.works/rivet.min.js"></script>
<script>rivet.config({
"embeds": {
    "_your gallery display key_": "rvt-embed-1"
}
});</script>
```
