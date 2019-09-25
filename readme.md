# C2O Developer Test  

We have provided some sample code for a poorly designed contact form. We would like you to add some new features to this form and clean up the current implementation.

The new features we require are:
1. Form submission should be handled in a separate file via AJAX
2. Add a field to the form to take an order number. Order numbers are always positive integers.
3. Add a comment field to the form so a customer can provide additional information in their query.
4. Each request has a category. Currently they are text field that have been hard coded. We would like to abstract these to a one to many relationship so that they can be easily extended.
 
 ## NB 
 The current schema for the contact form table has been provided. Please provide a copy of the table structure for your final answer in the `/database` folder. Please push your code to a separate branch.
 
### Getting Started
To get up and running you will need a [composer]([https://getcomposer.org/]) and [npm]([https://nodejs.org/en/]):  
```bash
npm install   
composer install
#run for development
npm run dev 
#run for production  
npm run build