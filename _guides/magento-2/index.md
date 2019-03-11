---
layout: guide
title: Magento 2 Implementation Guide
summary: This document provides instructions for completing the technical tasks associated with configuring a Magento 2 instance to integrate with Rivet’s e-commerce functionality and adding Rivet functionality to your Magento site.
---
This document provides instructions for completing the technical tasks associated with configuring a Magento 2 instance to integrate with Rivet’s e-commerce functionality and adding Rivet functionality to your Magento site. This guide supplements the [Rivet Implementation Guide](/guides/implementation/).

## Configure Magento
This section provides instructions for completing the technical tasks associated with configuring a Magento 2 instance to integrate with Rivet’s e-commerce functionality.

The integration process involves the following tasks:
- Create a new Integration in Magento 2
- Assign the Integration roles
- Communicate the Integration Access Token and URL to Rivet Customer Success.
- Add Product Page Displays
- Add Gallery Display

### Create a new Integration

It is best to create a new integration when configuring Rivet Works. Rivet requires access to certain resources that you will assign to the Integration.

{% include callout.html type="info" title="Note" message="The name of the Integration does not affect the Rivet integration." %}

### Assign Resources

The Rivet Magento 2 integration requires access to the following resources. Please assign access to these resources to the Rivet role.

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

### Create Integration

Navigate to your Magento 2 Dashboard. In the left hand menu click System, then under the Extensions Sub-menu click Integrations. Click "Add New Integration" and configure the permissions seen in the section above.


### Communicate the Integration information including the Access Token and URL of your Website.

Send [Rivet Customer Success](mailto:support@rivet.works) the API Access Token that is seen once the integration is created.

## Add Rivet to your site
Magento uses theme templates for customizing the store appearance and layout. You need to edit the template files directly in the file system. You can also edit the files remotely, upload, and overwrite the existing files. This section supplements the [Rivet Implementation Guide](/guides/implementation/).

The following sections show examples of adding a product-specific display to a product detail page and a Gallery Page.


### Product Detail Page

Add the following code to the PDP template at a path similar to `/app/design/frontend/<your-package-name>/default/template/catalog/product/view.phtml`.
You can find "_your filmstrip’s display key_" by logging into your Rivet Works account and clicking settings under your product display.

```html
<!-- Begin Rivetworks Integration -->
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
<!-- End Rivetworks Integration -->
```
### Category Page

Add the following code to the Category template in the desired location. You may need to adjust the variable "<?php echo Mage::registry('current_category')->getId();?>" if it is not pulling the correct CategoryId.
You can find "_your category display key_" by logging into your Rivet Works account and clicking settings under your Category display.

```html
<!-- Begin Rivetworks Integration -->                    
<div style="clear: both;" id="rvt-embed-1"> </div>
<script type="text/javascript" src="//webapp.rivet.works/rivet.min.js"></script>
<script> rivet.config ({
     "embeds": { "_your category display key_": "rvt-embed-1" },
     "pageContext": {
             "tags": {
                     "categoryId": "<?php echo Mage::registry('current_category')->getId();?>"
             }
     }
}); </script>

<!-- End Rivetworks Integration -->
```

### Gallery Page

In the Magento left hand menu click Content -> Pages -> Add a new page. Paste the code below in the HTML editor and replace "_your gallery display key_" by logging into your Rivet Works account and clicking settings under your Gallery display.

```html
<div id="rvt-embed-1"></div>
<script type="text/javascript" src="//webapp.rivet.works/rivet.min.js"></script>
<script>rivet.config({
"embeds": {
    "_your gallery display key_": "rvt-embed-1"
}
});</script>
```
