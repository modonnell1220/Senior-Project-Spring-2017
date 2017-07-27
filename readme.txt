README:

Overview: The team chose to have the file structure stick with the
related items of each section. We have all the Landlord page files
mostly in the Landlord folder and same for the Tenant. The User folder 
contains all the files to handle the sessions of logging into the system, 
creating a new User, and logging out of the system. The Documents 
handles the fpdf conversions leaving the Inbox which is incomplete but 
will be used for all messaging components. The assets folder is where 
all the common javascript and css is held the only hidden part is in 
the php folder which contains the payment section for the landlord and the tenant.

Landlord: The index.php is the landing page of the landlord section. 
From there they can call the addProperty_Query.php where can add properties 
to the directory or they can click on the created properties to view everything 
about them. When click on the property it takes them to the property.php file 
where they can add payments (payment.php) which inherits properties from the 
original assets folder explained in the overview of making payments. At this 
point you can edit the properties or create documents which will lead to the 
Documents section. All pictures added to the properties will be added to the 
Userpics folder. The last main item in the directory that is very important is the 
bulkImport.php which is used by the admin only where they fill in the landlord 
name at the top and load a preformatted data.txt file and then load the directory 
to bulk import all the data to that landlord in the database. 

Tenant: The tenant area is basic for it just has the main landing page file 
the index.php, payment, and profile files. The payment files once again inherit 
from the original directory of the assets/php folder where both the landlord and 
tenant access. The Search folder is accessed by clicking the search icon in 
the menu and lands you in the index of that page. This page searches for all the 
properties that are available to be rented and are displayed to the tenant end. 
They can then click on the property they like and apply to them and brings you to 
the application pages.

Documents: While a landlord is viewing a property, they can at any time create a 
Lease Agreement by selecting the new button in the documents section. This will 
take the landlord to the newLease.php page which will display a form pre-populated 
with relevant information. Upon loading the page, the form will suggest the current 
date, and pull information specific to the landlord, the tenant, and property to pre-fill 
the form fields. The landlord at this time may alter the information in any of the fields. 
The form is broken up into separate sections for location information, personal information, 
and the lease logistical information such as deposits, fees, rents, key, and other 
important information. When the landlord submits the form, it will then redirect to 
editLease.php where the form data will now be transformed into an auto-populated 
general purpose lease with the field values form the previous form embedded within. 
The landlord at this time may alter the lease as a whole in any way they see fit. 
Once the landlord is content with the lease they submit it for signing. This will 
then take the landlord to signLeaseLandlord.php where the landlord will create a 
digital signature to be stored on the database alongside the lease text. After this, 
a splash page will appear letting the landlord know to inform the tenant to review 
and sign the lease. From this point, when the tenant signs in to the site, they will
be automatically rerouted to reviewLease.php if a lease is waiting for their signature. 
On this page, the tenant can only review the lease, and accept it for signing. The tenant 
does not have any way of altering a lease. If the tenant accepts the lease agreement, 
they will be taken to a signature pad just like the landlord was, and their signature will
be stored on the database as well. After this point, either the tenant or the landlord 
may now view the lease from the property page at any time. Dong so will retrieve the lease text,
and signatures data from the database. Then on viewLease.php a pdf document will be 
rendered on the fly with the lease agreement, and all signatures stamped at the bottom. 
This will now be a downloadable pdf document.
