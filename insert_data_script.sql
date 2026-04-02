INSERT INTO Inventory
	(PROD_NAME, PROD_QTY, PRICE, PROD_TYPE)
	VALUES
		('Pulp Fiction', '15', '5.00', 'Movie'),
		('Titanic', '10', '5.00', 'Movie'),
		('C.H.U.D', '2', '100.00', 'Movie'),
		('Grand Theft Auto IV', '15', '9.99', 'Game'),
		('The Sims', '5', '9.99', 'Game'),
		('Jon Lehuta Documentary', '1', '1000000.00', 'Movie'),
		('Mario Kart Wii', '10', '9.99', 'Game'),
		('Avatar', '50', '14.99', 'Movie'),
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
		('5','1','1')
;
