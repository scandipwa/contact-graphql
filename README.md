# ScandiPWA_ContactGraphQl

This module provides GraphQL endpoints for Magento_Contact module.

## Endpoint description

### contactPageConfig

This endpoint allows getting whether Contact Us is enabled. 

```graphql
query GetContactPageConfig {
  contactPageConfig {
    enabled
  }
}
```

```json
{
  "contactPageConfig": {
    "enabled": true
  }
}
```

### contactForm

This endpoint allows sending mail message from customer

```graphql
mutation ContactForm(contact: ContactForm!) {
  contactForm(contact: ContactForm!) {
    message: String
  }
}
```

```json
{
  "contactForm": {
    "message": "success"
  }
}
```
