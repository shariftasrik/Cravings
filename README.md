  

# Cravings
Cravings is an online based multi-restaurant food ordering app offering diverse cuisines. Explore menus, customize meals, and enjoy quick delivery. With features like favorites, order tracking, and secure payments, it simplifies food ordering. Craving is your go-to platform for delicious meals delivered effortlessly.

  

## Team members
<table>
	 <thead> 
		 <tr> 
			 <th>ID</th> 
			 <th>Name</th> 
			 <th>Email</th> 
			 <th>Role</th> 
		 </tr> 
	 </thead> 
	 <tbody> 
		 <tr> 
			 <td>20220104095</td> 
			 <td>Nimur Rahman Sharif (Tasrik)</td> 
			 <td>shariftasrik12@gmail.com</td> 
			 <td>Lead (Frontend+Backend)</td> 
		 </tr> 
		 <tr> 
			 <td>20220104089</td> 
			 <td>Afnan Zaman Ifty</td> 
			 <td>zamanafnan62@gmail.com</td> 
			 <td>Backend</td>   
		 </tr> 
		 <tr> 
			 <td>20220104080</td> 
			 <td>Utsha Karmakar</td> 
			 <td>utshakarmakar04109@gmail.com</td> 
			 <td>Backend</td>   
		 </tr> 
		 <tr> 
			 <td>20220104099</td> 
			 <td>Prottoy Roy</td> 
			 <td>prottoyroy99@gmail.com</td> 
			 <td>Frontend</td>   
		 </tr> 
	 </tbody> 
 </table>

  

## Target Audience

  

The target audience for "Cravings" startup includes urban dwellers in cities like Dhaka and Chattogram, particularly young adults (18–35), working professionals, and students who frequently dine out or order food online. Families seeking convenience, tourists exploring local cuisine, and health-conscious individuals looking for specific meal options are also key segments. Emphasis should be on affordability, local cuisine, and support for mobile payment methods like bKash. Social media-savvy food enthusiasts who rely on reviews and discounts can be engaged through targeted marketing campaigns. By catering to these diverse needs, the app can thrive in Bangladesh's growing food delivery market.

  
  

## Tech Stack
<table>
	 <thead> 
		 <tr> 
			 <th>Teck Stack</th> 
			 <th>We Use</th> 
		 </tr> 
	 </thead> 
	 <tbody> 
		 <tr> 
			 <td>Backend</td> 
			 <td>Laravel</td> 
		 </tr> 
		 <tr> 
			 <td>Frontend</td> 
			 <td>php</td>   
		 </tr> 
		 <tr> 
			 <td>Database</td> 
			 <td>phpMyAdmin</td>  
		 </tr> 
		 <tr> 
			 <td>Payment Process</td> 
			 <td>Stripe</td> 
		 </tr> 
		 <tr> 
			 <td>Rendering Method</td> 
			 <td>CSR (Client-Side Rendering)</td> 
		 </tr> 
	 </tbody> 
 </table>
  
## UI Design
Figma Prototype: <a href="https://www.figma.com/proto/mIyp8Q47ff0GPxNW5YWKlt/Cravings?page-id=0%3A1&node-id=14-5&p=f&viewport=2885%2C287%2C0.16&t=3aQJuW04wsA8tw4M-1&scaling=min-zoom&content-scaling=fixed&starting-point-node-id=176%3A12">Figma Prototype Link</a> <br/>
Figma Design   : <a href="https://www.figma.com/design/mIyp8Q47ff0GPxNW5YWKlt/Cravings?node-id=0-1&t=ZzZFWT9q5wwfBqNU-1">Figma Design Link</a>


## Project Features

### User Section
<ul>
	<li>Multi User Authentication</li>
	<li>Menu, Product, Gallery</li>
	<li>CRUD operations</li>
	<li>Search/Filter</li>
	<li>Apply Coupon</li>
	<li>Cart Page</li>
	<li>Apply Cash on Delivery</li>
	<li>Apply Online Payment</li>
</ul>

### Restaurant Section
<ul>
	<li>Multi Restaurant Authentication</li>
	<li>Multi Admin for a single Restaurant</li>
	<li>Menu, Product, Coupon, Gallery for new Customer</li>
	<li>CRUD operations</li>
	<li>Order Form</li>
	<li>Download Order Invoice</li>
</ul>

### Admin Section
<ul>
	<li>Multi Admin Authentication</li>
	<li>Forget Password</li>
	<li>Admin Panel</li>
	<li>Manage Order Form</li>
</ul>

##  API Endpoints
### **Authentication**

#### Customer Authentication

-   **POST** `/api/customers/register` - Customer registration.
-   **POST** `/api/customers/login` - Customer login.
-   **POST** `/api/customers/logout` - Customer logout.
-   **POST** `/api/customers/forgot-password` - Forgot password (email recovery).
-   **POST** `/api/customers/reset-password` - Reset password with token.

#### Restaurant Authentication

-   **POST** `/api/restaurants/register` - Restaurant owner registration.
-   **POST** `/api/restaurants/login` - Restaurant owner login.
-   **POST** `/api/restaurants/logout` - Restaurant owner logout.
-   **POST** `/api/restaurants/forgot-password` - Forgot password.
-   **POST** `/api/restaurants/reset-password` - Reset password with token.

#### Admin Authentication

-   **POST** `/api/admin/login` - Admin login.
-   **POST** `/api/admin/logout` - Admin logout.

----------

### **Customer Management**

-   **GET** `/api/customers/me` - Fetch customer details (My Account).
-   **PUT** `/api/customers/me` - Update customer account details.
-   **DELETE** `/api/customers/me` - Delete customer account.

----------

### **Restaurant Management**

#### By Restaurant Owner

-   **GET** `/api/restaurants/me` - Fetch restaurant owner details.
-   **PUT** `/api/restaurants/me` - Update restaurant owner details.
-   **DELETE** `/api/restaurants/me` - Delete restaurant account.
-   **GET** `/api/restaurants/my-orders` - View orders placed at their restaurant.
-   **PATCH** `/api/restaurants/my-orders/:orderId` - Update order status (e.g., accepted, prepared, delivered).
-   **PATCH** `/api/restaurants/menu/prices` - Update menu item prices.
-   **POST** `/api/restaurants/menu` - Add a new menu item.
-   **PUT** `/api/restaurants/menu/:itemId` - Edit menu item details.
-   **DELETE** `/api/restaurants/menu/:itemId` - Remove menu item.

#### By Admin

-   **GET** `/api/restaurants` - Fetch all restaurants.
-   **PATCH** `/api/restaurants/:restaurantId/approve` - Approve restaurant registration.
-   **DELETE** `/api/restaurants/:restaurantId` - Remove restaurant.

----------

### **Order Management**

#### Customer Orders

-   **POST** `/api/orders` - Place an order with multiple items from a restaurant.
-   **GET** `/api/orders` - View all orders by the customer.
-   **GET** `/api/orders/:orderId` - View details of a specific order.
-   **DELETE** `/api/orders/:orderId` - Cancel an order (if not yet processed).

#### Payment Options

-   **POST** `/api/payments/cash-on-delivery` - Apply cash on delivery.
-   **POST** `/api/payments/online` - Apply online payment (e.g., via bKash, card).
-   **POST** `/api/payments/verify/:paymentId` - Verify online payment.

----------

### **Menu Management**

-   **GET** `/api/menu` - Fetch menu for a restaurant.
-   **GET** `/api/menu/:itemId` - Fetch details of a specific menu item.

----------

### **Admin Panel Management**

-   **GET** `/api/admin/dashboard` - Admin dashboard data (e.g., total sales, active restaurants).
-   **GET** `/api/admin/customers` - Fetch all customers.
-   **DELETE** `/api/admin/customers/:customerId` - Remove a customer.
-   **GET** `/api/admin/restaurants` - Fetch all restaurants.
-   **PATCH** `/api/admin/restaurants/:restaurantId` - Modify restaurant details.
-   **GET** `/api/admin/orders` - View all orders.

----------

### **Search and Filtering**

-   **GET** `/api/restaurants/search` - Search restaurants by name, cuisine, or location.
-   **GET** `/api/menu/search` - Search menu items across restaurants.

----------

### **Reviews and Ratings**

-   **POST** `/api/reviews` - Add a review for a restaurant.
-   **GET** `/api/reviews/:restaurantId` - Fetch reviews for a restaurant.
-   **PATCH** `/api/reviews/:reviewId` - Edit a review.
-   **DELETE** `/api/reviews/:reviewId` - Delete a review.

## Milestones
<table>
	 <thead> 
		 <tr> 
			 <th>Milestones</th> 
			 <th>We Cover</th> 
		 </tr> 
	 </thead> 
	 <tbody> 
		 <tr> 
			 <td>Checkpoint 1</td> 
			 <td>
				 <ul>
					<li>Frontend, Backend, Database setup</li>
					<li>Customer registration and login pages</li>
					<li>customer authentication</li>
                    <li>Admin panel setup</li>
                    <li>Restaurant authentication</li>
                    <li>Restaurant panel setup</li>
                    <li>Customer Profile Setup</li>
                    <li>Admin Backend Category</li>
                    <li>fetching a list of restaurants and  menu display page</li>
				</ul>
			</td>
		 </tr> 
		 <tr> 
			 <td>Checkpoint 2</td> 
			 <td>
				 <ul>
                     <li>Table for User, Restaurants and MenuItem at Database</li>
					 <li>Order History</li>
					 <li>Multi Item Cart functionality</li>
					 <li>Payment options</li>
					 <li>Approve or Reject new Restaurants registration by Admin</li>
					 <li>Restaurant Dash Board</li>
					 <li>Admin Dashboard</li>
				 </ul>
			 </td>   
		 </tr> 
		 <tr> 
			 <td>Checkpoint 3</td> 
			 <td><ul>
					 <li>Customers can search restaurants by name or foodItem name</li>
					 <li>Customers can leave reviews for Restaurants</li>
					 <li>Admin can remove inactive or problematic restaurants</li>
					 <li>Payment options by Stripe</li>
					 <li>Approve or Reject new Restaurants registration by Admin</li>
				 </ul>
				</td>  
		 </tr> 
	 </tbody> 
 </table>


