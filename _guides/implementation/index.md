---
layout: guide
title: Implementation Guide
summary: The Implementation Guide provides instructions for completing the technical tasks associated with integrating your end-to-end Rivet solution. Please see the Glossary at the end of this document for the definition of Platform-related terms.
---
This document provides instructions for completing the technical tasks associated with integrating your end-to-end Rivet solution. Please see the Glossary at the end of this document for the definition of Platform-related terms.

## Technical Tasks

The implementation process involves the following tasks:
- Create a CNAME record to brand the consumer-facing URL (see Branding the URL)
- Determine the tagging architecture to use based on your display requirements (see Activity Tagging)
- Set up triggered email with custom Activity URL containing dynamically generated tags (see Integrating Into Your Email System)
- Integrate one or more JavaScript embeds on your website  (see Website Integration)
- Host Terms of Use (or Terms & Conditions if running a sweepstakes or contest) and provide your Customer Success Manager the URL where terms are located.

## Branding the URL

All Activities hosted on the Rivet Platform can be accessed on the webapp.rivet.works domain. You will often use this domain for testing while you are creating your activities. Prior to deployment, our customers typically opt to expose activities under their own domain or a subdomain for a completely branded user experience. (For example, if your domain is acme.com, then you might host the activity under the subdomain customer.acme.com.)

### Rivet URL Example

Activities hosted under the `webapp.rivet.works` subdomain use the following URL structure:

```
http://webapp.rivet.works/activity#/{application}/engage/{activity}/
```

In this example, you would replace {application} and {activity} with the application and activity nicknames that you configured for your activity in the Rivet Admin.

### Branded URL Example

Customizing the domain requires you to create a DNS CNAME entry for the desired subdomain (in this example, customers.acme.com) that points at a Rivet hosted domain (e.g. acme.rivet.works). Your Rivet Customer Success Manager will work with you to set up the Rivet subdomain.

Once you have created the CNAME entry pointing to the Rivet subdomain, notify your Customer Success Manager.  Within 24 hours of notifying your Customer Success Manager you will be able to access your activity under the custom domain. In the example above, you would access the activity at:

```
http://customers.acme.com/activity#/{application}/engage/{activity}/
```

## Activity Tagging

Activity tagging is a powerful feature of the Rivet Platform’s user-generated content capture and display capabilities. By passing tags to an activity via the activity URL, the user-generated content submitted through the activity will be associated with the tags automatically.

This section will provide you with the information you need to understand and implement a tagging architecture designed to allow for better display and analysis of the user-generated photo content collected by the Rivet Platform.

### Tags

To tag an activity submission, you simply add the list of tags and their associated values to the activity URL using the following syntax:

```
http://customer.acme.com/activity#/{application}/engage/{activity}?tag1=value1&tag2=value2…tag_n=value_n
```

The tags component of the URL is optional, and users will be able to complete activities with or without tags. However, tags allow you to capture additional information (e.g. product SKU, category, color, etc.) that is stored alongside the activity submission. The tags can then be used to filter the submissions for display, analysis, or export to a CRM. For more information on using tags for display, see Website Integration.

Tags are completely arbitrary. There is no limit on the number of tags that can be included in the activity URL; however, browsers do limit the length of a URL (the actual limits vary by browser, but older browsers will limit URLs to no more than 2,048 characters).

### Tagging Architecture

While tags are arbitrary, it is highly recommended that some thought be put into the tags and how they will be used.

For example, consider a campaign to capture photos of people’s experiences using products that they recently purchased. You can associate a specific product with an activity submission by appending an identifying tag, such as the product SKU, to the end of the activity URL. The branded URL from above now becomes:

`http://customer.acme.com/activity#/{application}/engage/{activity}/?sku=abc123`

### Multiple Tag Values

To further categorize an activity submission, you may choose to add additional tags, such as “color”, “type”, “model”, “style”, etc, to the activity URL. Adding the color tag to the prior URL produces:

`http://customer.acme.com/activity#/{application}/engage/{activity}/?sku=abc-123&color=blue`

In order to properly associate each activity submission with the product that the individual purchased, the value of the sku tag must change to reflect the product purchased. In other words, the URL used to submit the activity will vary based upon the product that was purchased. For example, if an individual purchased a blue product with the SKU “xyz-890”, the activity URL would become:

`http://customer.acme.com/activity#/{application}/engage/{activity}/?sku=xyz-890&color=blue`

If, instead, the color of the product was red, the URL would be:

`http://customer.acme.com/activity#/{application}/engage/{activity}/?sku=xyz-890&color=red`

Remember that you can assign as many tags to the activity URL as you want; you are limited only by the maximum URL length supported by most web browsers. (As a general guideline, URLs should be no longer than 2,048 characters.)

When formulating your tagging architecture, begin with the end in mind …

### Reserved Characters

As tags are part of a URL, there are certain characters that cannot be used in tag names and values. Specifically, the following characters cannot be used: & ? = #

## Tagging Implications on Display Functionality

Photos displayed through any of the three display types currently offered by the Rivet Platform can be hyperlinked to a URL on your website. The tag value(s) you include in the activity URL will impact the functionality of photo linking.

See Photo Display Hyperlinking for more information on hyperlinking photos to specific pages on your website.

## Integrating Into Your Email System

To dynamically construct the URL and associate the appropriate tag values for each user, first ensure that the tag values are part of your email file/database.  For example, the structure of the file could look something like this:

| Email | FName | Gender | Address | City | State | SKU | Category1 | Category2 |
| ----- | ----- | ------ | ------- | ---- | ----- | --- | --------- | --------- |
| dianna@rivet.works | Dianna | F | 8300 N Lamar Blvd | Austin | TX | right-pack-typ7 | everyday-bags | backpacks |
| jason@yahoo.comJason | Jason | M | 123 North Blvd | New York | NY | big-student-tdn7 | everyday-bags | backpacks |
| gabe@hotmail.com | Gabe | M | 3423 Swan Song Ln | Nashville | TN | coho-t21r | outdoor-bags | daypacks |
{:.table .table-responsive}

The link in your email would then be constructed using the dynamic variable structure specific to your email system. An example, where {VARIABLE} is the structure for dynamic variables in the MailChimp email system:

`http://projects.build.com/activity#/build/engage/buildprojectphotos?sku={SKU}*?cat1={CATEGORY1}?cat2={CATEGORY2}`

## <a name="website_integration"></a>Website Integration

Using a few lines of JavaScript code, you can display photos submitted via the Rivet Platform directly on your website. This section describes how to integrate the JavaScript into any page on your website. It also provides instructions for filtering photos using tags (for more information on tags, see Activity Tagging).

### Embedding the JavaScript (rivet.min.js)
Begin by copying the embed code from the Embeds page of the Rivet Admin. The code snippet should look like the following:

```javascript
<script type="text/javascript" src="http://webapp.rivet.works/rivet.min.js"></script>
<script>
   rivet.config({
 	   "embeds": {
 		"AcmeEmbed": "acme-photo-div"
 		}
 	   });
</script>
```

Paste the code snippet at the bottom of the page right before the </body> tag. Replace “AcmeEmbed” with your specific embed key and replace the text “acme-photo-div” with the name of the HTML <div> where the photos will be displayed on your page. When properly embedded, this will display all photos submitted via any activity associated with the embed to the HTML <div> that you have specified.

If you wish to filter the photos using tags (to display only photos of a product with a specific SKU, for instance) you must include a page context section in the JavaScript code. For example, to display photos of the product with the SKU abc-123, you would modify the embed as follows:

```javascript
<script type="text/javascript" src="http://webapp.rivet.works/rivet.min.js"></script>
<script type="text/javascript">
 	rivet.config({
 		embeds: {
 			"AcmeEmbed": "product-photos"
 		},
 		pageContext: {
 			"tags": {
 			   "sku": "abc-123"
 			 }
 		}
</script>
```

### Tagging in Dynamically Generated Pages

When using a single server-side script to dynamically generate product, service, or other content pages based on URL parameters, you will need to dynamically generate the pageContext section in the JavaScript shown above to include the tags appropriate for the product, service, or content to be displayed on the page. In the previous example, if a user requests the page with the SKU xyz-890, you will need to generate the following page context:

```json
pageContext: {
 	"tags": {
 	   "sku": "xyz-890"
 	}
}
```

If you further wanted to filter using the tag color with a color of “blue”, you would generate the following page context:

```json
pageContext: {
 	"tags": {
 	   "sku": "xyz-890",
 	   "color": "blue"
 	}
}
```

### Page Context & Tagging Logic

As previously discussed, you can filter photos using any number and combination of tags. For more fine-grained control, you can combine tags using Rivet’s tagging logic to restrict the photos an embed displays.

In general, tags are additive (i.e. they are combined using a logical AND). The exception is that within an individual tag, if the tag is assigned an array of values, the values act as a logical OR. For example, an embed that has the following page context displays the photos that have the tag sku with the value “abc-123” and the tag color with the value “blue”.

```json
pageContext: {
 	"tags": {
 	   "sku": "abc-123",
 	   "color": "blue"
 	}
}
```

The following page context displays the photos that are tagged with the tag sku with the values “abc-123” or “xyz-890”.

```json
"pageContext": {
	"tags": {"sku": ["abc-123", "xyz-890"]}
}
```

If the value for a tag is empty, the embed displays photos that have the tag regardless of the value. The following page contexts cause an embed to display all media that have a sku tag.

```json
"pageContext": {
	"tags": {"sku": ""}
}
```

An embed with the following page context displays photos that have a category tag with values of “widget” or “gadget” that also have any value for the sku tag.

```json
"pageContext": {
	"tags": {"category": ["widget", "gadget"],
               "sku": ""}
}
```

The page context can also restrict an embed to displaying photos taken within a radius of a latitude and longitude coordinate. The following page context displays photos within a 5-kilometer radius of Austin, TX, USA.

```json
"pageContext": {
 	"geoRegion": {"lat": 30.25,
 		"lon": -97.75,
 		"r": "5 km"
 	}
}
```

The units for the radius can be kilometers or miles. The default is miles.

### Photo Display Hyperlinking

The destination of the URL is determined by the URL Template configured in the Rivet Admin at the Embed level. If a URL template is provided, then the photos that are displayed will be linked to the URL provided. The URL template can be parameterized by wrapping variable names in braces: {variable}

Permissible variables include the name of any tag provided when the activity was completed by the user (i.e. any tag that appeared in the activity URL).

Consider the URL template: `http://www.acme.com/{sku}/{color}`

For each photo displayed in the gallery, the {sku} portion of the hyperlink URL will be replaced by the value of the sku tag that was stored with the corresponding activity submission. The same is true for the color tag. This technique can be used to create a photo gallery at a site-wide or category-level that links off to deeper pages on your site.

If the value of the tag in the URL template is NOT captured or is absent, that particular photo will not be hyperlinked and the user-facing clickable text, such as “Shop Now” will be suppressed.

### Example

Samantha, an Acme.com customer, submits a photo through the following URL, which you have generated for her:

```http://customer.acme.com/activity#/acmeApp/engage/showUsYourWidget/?sku=abc-123&color=red```

Samantha’s photo is then displayed on the Acme.com site. When a visitor Acme.com views Samantha’s photo, the photo will click through to:

```http://www.acme.com/abc-123/red```

## Glossary of Terms

| Term | Definition |
| ---- | ---------- |
| Activity | An Activity is the experience created to engage users and capture photos, videos, and profile, location and other forms of meta data. |
{:.table .table-responsive}
