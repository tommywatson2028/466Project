INSERT INTO Inventory
	(PROD_NAME, PROD_QTY, PRICE, PROD_TYPE, IMG_URL, PROD_DESC)
	VALUES
		('Pulp Fiction', '15', '3.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/thumb/3/3b/Pulp_Fiction_%281994%29_poster.jpg/250px-Pulp_Fiction_%281994%29_poster.jpg'),
		('Titanic', '10', '3.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/thumb/1/18/Titanic_%281997_film%29_poster.png/250px-Titanic_%281997_film%29_poster.png'),
		('C.H.U.D', '2', '100.00', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/thumb/7/7a/CHUD_poster.jpg/250px-CHUD_poster.jpg'),
		('Grand Theft Auto IV', '15', '9.99', 'Game', 'https://upload.wikimedia.org/wikipedia/en/thumb/b/b7/Grand_Theft_Auto_IV_cover.jpg/250px-Grand_Theft_Auto_IV_cover.jpg'),
		('The Sims', '5', '5.99', 'Game', 'https://upload.wikimedia.org/wikipedia/en/thumb/d/db/The_Sims_Online_Cover.jpg/250px-The_Sims_Online_Cover.jpg'),
		('Jon Lehuta Documentary', '1', '10000.00', 'Movie', '/jonDoc.png'),
		('Mario Kart Wii', '10', '7.99', 'Game', 'https://upload.wikimedia.org/wikipedia/en/d/d6/Mario_Kart_Wii.png'),
		('The Dark Knight', '12', '6.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/thumb/1/1c/The_Dark_Knight_%282008_film%29.jpg/250px-The_Dark_Knight_%282008_film%29.jpg'),
		('Jurassic Park', '8', '2.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/e/e7/Jurassic_Park_poster.jpg'),
		('The Matrix', '7', '3.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/thumb/d/db/The_Matrix.png/250px-The_Matrix.png'),
		('Forrest Gump', '9', '2.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/6/67/Forrest_Gump_poster.jpg'),
		('Gladiator', '6', '3.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/thumb/f/fb/Gladiator_%282000_film_poster%29.png/250px-Gladiator_%282000_film_poster%29.png'),
		('Interstellar', '11', '6.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/b/bc/Interstellar_film_poster.jpg'),
		('Halo 3', '14', '9.99', 'Game', 'https://upload.wikimedia.org/wikipedia/en/thumb/b/b4/Halo_3_final_boxshot.JPG/250px-Halo_3_final_boxshot.JPG'),
		('Call of Duty: Modern Warfare', '20', '9.99', 'Game', 'https://upload.wikimedia.org/wikipedia/en/thumb/5/5f/Call_of_Duty_4_Modern_Warfare.jpg/250px-Call_of_Duty_4_Modern_Warfare.jpg'),
		('Minecraft', '25', '7.99', 'Game', 'https://minecraft.wiki/images/thumb/Minecraft_xbox360_retail_cover.jpg/800px-Minecraft_xbox360_retail_cover.jpg?1cb57'),
		('The Legend of Zelda: Twilight Princess', '8', '7.99', 'Game', 'https://upload.wikimedia.org/wikipedia/en/0/0e/The_Legend_of_Zelda_Twilight_Princess_Game_Cover.jpg'),
		('Madden NFL 08', '10', '4.99', 'Game', 'https://upload.wikimedia.org/wikipedia/en/4/4c/Madden_NFL_08_Coverart.png'),
		('Spider-Man 2', '3', '3.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/thumb/4/4e/Spider-Man_2_USA_poster.jpg/250px-Spider-Man_2_USA_poster.jpg'),
		('Rock Band 2', '6', '5.99', 'Game', 'https://upload.wikimedia.org/wikipedia/en/0/01/Rock_Band_2_Game_Cover.JPG')
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
