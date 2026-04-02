INSERT INTO Inventory
	(PROD_NAME, PROD_QTY, PRICE)
	VALUES
		('Teddy Bear', '15', '10.00'),
		('Slippers', '10', '15.00'),
		('Pokemon Card Pack', '20', '5.00'),
		('Socks', '15', '5.00'),
		('Laptop', '2', '800.00'),
		('Chair', '2', '50.00'),
		('Volleyball', '10', '50.00'),
		('Blanket', '5', '25.00'),
		('Pure Columbian Cocaine (.125 oz)', '400', '250.00'),
		('Fishing Rod', '2', '75.00'),
		('Laundry Detergent', '5', '20.00'),
		('Costco Hotdog', '100', '1.50'),
		('Traffic Cone', '5', '35.00'),
		('Jon Lehuta Hair', '5', '27.00'),
		('Backpack', '3', '40.00'),
		('Calculator', '3', '40.00'),
		('Tape', '15', '5.00'),
		('Bathmat', '3', '25.00'),
		('Mug', '10', '10.00'),
		('Rice Cooker', '2', '25.00')
;

INSERT INTO Customers
	(CUSTOMER_ID, CUSTOMER_PASS)
	VALUES
		('Junkie','ILoveWeed420'),
		('FredJohnson','FredsPassword'),
		('BenDover','Password#123'),
		('UrMom','IsFat'),
		('Agatha','HowToGoogle')
;

INSERT INTO Orders
	(CUSTOMER_ID, ORDER_STATUS)
	VALUES
		('Junkie','Complete'),
		('FredJohnson','Complete'),
		('BenDover','Processing'),
		('UrMom','Processing'),
		('Agatha','Complete')
;

INSERT INTO OrderContains
	(ORDER_ID, PROD_ID, ORDER_QTY)
	VALUES
		('1','9','100'),
		('2','2','2'),
		('2','3','10'),
		('2','6','1'),
		('2','7','1'),
		('3','11','4'),
		('3','10','3'),
		('3','19','2'),
		('4','20','1'),
		('4','1','1'),
		('4','2','1'),
		('5','1','1'),
;