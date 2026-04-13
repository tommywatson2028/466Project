INSERT INTO Inventory
	(PROD_NAME, PROD_QTY, PRICE, PROD_TYPE)
	VALUES
		('Pulp Fiction', '15', '3.99', 'Movie'),
		('Titanic', '10', '3.99', 'Movie'),
		('C.H.U.D', '2', '100.00', 'Movie'),
		('Grand Theft Auto IV', '15', '9.99', 'Game'),
		('The Sims', '5', '5.99', 'Game'),
		('Jon Lehuta Documentary', '1', '10000.00', 'Movie'),
		('Mario Kart Wii', '10', '7.99', 'Game'),
		('The Dark Knight', '12', '6.99', 'Movie'),
		('Jurassic Park', '8', '2.99', 'Movie'),
		('The Matrix', '7', '3.99', 'Movie'),
		('Forrest Gump', '9', '2.99', 'Movie'),
		('Gladiator', '6', '3.99', 'Movie'),
		('Interstellar', '11', '6.99', 'Movie'),
		('Halo 3', '14', '9.99', 'Game'),
		('Call of Duty: Modern Warfare', '20', '9.99', 'Game'),
		('Minecraft', '25', '7.99', 'Game'),
		('The Legend of Zelda: Twilight Princess', '8', '7.99', 'Game'),
		('Madden NFL 08', '10', '4.99', 'Game'),
		('Spider-Man 2', '3', '3.99', 'Movie'),
		('Rock Band 2', '6', '5.99', 'Game')
;

INSERT INTO Users
	(USER_IDX, USER_PASS)
	VALUES
		('Junkie','ILoveWeed420'),
		('FredJohnson','FredsPassword'),
		('BenDover','Password#123'),
		('UrMom','IsFat'),
		('Agatha','HowToGoogle')
;

INSERT INTO Users
	(USER_IDX, USER_PASS, IS_OWNER, IS_EMPLOYEE)
	VALUES
		('Owner','Owner', TRUE, TRUE),
		('Emp','Emp', FALSE, TRUE)
;

INSERT INTO Orders
	(CUSTOMER_ID,  SHIPPING_ADDRESS, BILLING_ADDRESS, CREDIT_CARD_NUM, CVV_NUM, ORDER_STATUS, CONTACT_EMAIL)
	VALUES
		('Junkie','1 Main Ave, DeKalb, IL, 60115','1 Main Ave, DeKalb, IL, 60115','420420420420','420','Complete', 'junkie@gmail.com'),
		('FredJohnson','2 Main Ave, DeKalb, IL, 60115','2 Main Ave, DeKalb, IL, 60115','3715964312432135','555','Complete', 'fred@gmail.com'),
		('BenDover','3 Main Ave, DeKalb, IL, 60115','3 Main Ave, DeKalb, IL, 60115','13146573683','666','Processing', 'ben@gmail.com'),
		('UrMom','4 Main Ave, DeKalb, IL, 60115','4 Main Ave, DeKalb, IL, 60115','05873242545768','777','Processing', 'urmom@gmail.com'),
		('Agatha','5 Main Ave, DeKalb, IL, 60115','5 Main Ave, DeKalb, IL, 60115','673232576878','111','Complete', 'agatha@gmail.com')
;

INSERT INTO OrderContains
	(ORDER_ID, PROD_ID, ORDER_QTY)
	VALUES
		('1','9','1'),
		('2','2','1'),
		('2','3','1'),
		('2','6','1'),
		('2','7','1'),
		('3','11','1'),
		('3','10','1'),
		('3','19','1'),
		('4','20','1'),
		('4','1','1'),
		('4','2','1'),
		('5','1','1')
;
