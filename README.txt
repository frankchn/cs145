I WOULD LIKE TO ENTER THE AUCTIONBASE CONTEST

** NOTE: ** Please ensure that data and data/project.db are set to world-writable. The application will not function otherwise as it cannot write to the database.

Basic Capability Descriptions
=============================

* Change the "current time."
  Users can change the current time simply by changing the time on the bottom gray bar and hitting submit. The current page will reload items as appropriate to reflect the new time.

* Ability for auction users to enter bids on open auctions.
  Users must first login using any valid user in the database. Then they can proceed to any open auction page and enter a bid that is greater than the current bids. Bids greater than the BuyPrice will be rounded down to the buy price. An example user is "classicalowl" (no quotes).

* Automatic auction closing. 
  Once the conditions are reached, the bid textbox will not appear even if the user is logged in.

* Ability to see the winner of a closed auction.
  The user in the bid history that is highlighted in green is the current winner of the auction.

* Ability to browse auctions of interest.
  The user can click on the "Items" link and browse. Alternatively, they can click on users or categories, search for a specific user or category, then filter auctions by that person.

* Ability to find an (open or closed) auction based on itemID.
  Click on Items and enter the item ID in the first textbox on the left, and check the Show Closed Auctions checkbox. Hit search. If the Item exists, then it will show as the result. 

  ** NOTE **: I deliberately did not show auctions that are not yet open, even if Show Closed Auctions exist, to mimic the behavior of a real auction site.


Input Parameters
================

 - Item ID
 - Keyword
 - Current Price (minimum)
 - Current Price (maximum)
 - Option to Show/Hide Closed Auctions

 - Filter by Category (clicking on the Category page then selecting a category)
 - Filter by Users (clicking on the Users page then selecting a User)

Additional Capabilities
=======================

Major features include:

* Single Page AJAX app

  The most important new feature in this application is that it is a single page app. Notice that after loading index.html, the page never reloads. In fact, we have loaded all the necessary javascript during that first page load and will only communicate with the backend strictly via RESTful AJAX calls (detailed in the next section).

  This way of building web applications (single page apps) is the way in which almost all modern commercial web applications are built (Facebook, Twitter, Quora, Gmail, etc...). Although it certainly takes more effort than traditional applications, websites built in this manner are usually very responsive and have a much better user experience than websites which forces a reload for every single click / action.

  This was achieved with AngularJS and jQuery.

* Full RESTful / JSON API calls

  As mentioned above, the website communicates with the PHP code only via RESTful APIs that talk to each other than JSON. For instance, a serach query for items with the keyword "camera" and a minimum price of $50 would result in a HTTP GET request of /cs145/api/items.php?category=-1&closed=0&itemidlike=&max=&min=50&numitems=20&search=camera. JSON is returned from the server as an array of Item objects and immediately consumed (very easy to do in JavaScript) and published as a table to the end-user for display.

  Similarly, making a new bid on an item will make a POST request to /cs145/api/bids.php with JSON "{"ItemID":"1496971043","Amount":"75"}". The PHP backend consumes the JSON, does additional sanity checks and returns a HTTP status 200 if it works, and an 4xx error if something goes wrong (i.e. bid too low)

  This design allows easy extension/modification of both the front-end (i.e. building an iPhone application) and the backend (i.e. moving away from PHP into Python) very easy since the interface is very well-defined and one can be replaced without major disruption to each other.

* Responsive Page Design

  Finally, this web application is designed with both large screen devices (e.g. computers/tablets) and small screen devices in mind. You can simulate a small-screen by resizing the window to a narrow width. You will see that the page collapses into a single column format, perfect for smart phones. All functionality is retained.

Other features include:

* Google Image Search integration - Integrated with Google Image Search to display the first result in a search of the title of the image in Google. Displays a placeholder if no results ar found.

* Improved visual design
* Basic statistics page
* New user registration
* Login mechanism for users
* Listing of Popular Categories
* Listing of Auctions that will close soon
* Header banner promoting pages


Libraries and Tools Used
========================

* jQuery
* jQuery Parallax Content Slider (Tympanus / Codrops)
* Twitter Bootstrap
* AngularJS

Images and Graphics Used
========================

Shattered - Subtle Patterns (http://subtlepatterns.com/shattered/)