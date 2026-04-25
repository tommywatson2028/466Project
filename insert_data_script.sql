INSERT INTO Inventory
	(PROD_NAME, PROD_QTY, PRICE, PROD_TYPE, IMG_URL, PROD_DESC)
	VALUES
		('Pulp Fiction', '15', '3.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/thumb/3/3b/Pulp_Fiction_%281994%29_poster.jpg/250px-Pulp_Fiction_%281994%29_poster.jpg', 'A nonlinear crime film following interconnected stories in Los Angeles.'),
		('Titanic', '10', '3.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/thumb/1/18/Titanic_%281997_film%29_poster.png/250px-Titanic_%281997_film%29_poster.png', 'A tragic love story set aboard the doomed RMS Titanic.'),
		('C.H.U.D', '2', '100.00', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/thumb/7/7a/CHUD_poster.jpg/250px-CHUD_poster.jpg', 'A cult horror film about underground creatures in New York City.'),
		('Grand Theft Auto IV', '15', '9.99', 'Game', 'https://upload.wikimedia.org/wikipedia/en/thumb/b/b7/Grand_Theft_Auto_IV_cover.jpg/250px-Grand_Theft_Auto_IV_cover.jpg', 'An open-world crime game following an immigrant navigating Liberty City.'),
		('The Sims', '5', '5.99', 'Game', 'https://upload.wikimedia.org/wikipedia/en/thumb/d/db/The_Sims_Online_Cover.jpg/250px-The_Sims_Online_Cover.jpg', 'A life simulation game where players control characters and their daily lives.'),
		('Jon Lehuta Documentary', '1', '10000.00', 'Movie', '/jonDoc.png', 'A rare documentary chronicling the legendary life of Jon Lehuta.'),
		('Mario Kart Wii', '10', '7.99', 'Game', 'https://upload.wikimedia.org/wikipedia/en/d/d6/Mario_Kart_Wii.png', 'A fast-paced kart racing game featuring iconic Nintendo characters.'),
		('The Dark Knight', '12', '6.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/thumb/1/1c/The_Dark_Knight_%282008_film%29.jpg/250px-The_Dark_Knight_%282008_film%29.jpg', 'Batman faces the Joker in a gritty battle for Gotham City.'),
		('Jurassic Park', '8', '2.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/e/e7/Jurassic_Park_poster.jpg', 'Scientists bring dinosaurs back to life in a disastrous theme park.'),
		('The Matrix', '7', '3.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/thumb/d/db/The_Matrix.png/250px-The_Matrix.png', 'A hacker discovers reality is a simulated world controlled by machines.'),	
		('Forrest Gump', '9', '2.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/6/67/Forrest_Gump_poster.jpg', 'The life journey of a simple man who witnesses historic events.'),		
		('Gladiator', '6', '3.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/thumb/f/fb/Gladiator_%282000_film_poster%29.png/250px-Gladiator_%282000_film_poster%29.png', 'A Roman general seeks revenge after betrayal and slavery.'),		
		('Interstellar', '11', '6.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/b/bc/Interstellar_film_poster.jpg', 'Explorers travel through space to save humanity from extinction.'),
		('Halo 3', '14', '9.99', 'Game', 'https://upload.wikimedia.org/wikipedia/en/thumb/b/b4/Halo_3_final_boxshot.JPG/250px-Halo_3_final_boxshot.JPG', 'A sci-fi shooter concluding the fight between humanity and the Covenant.'),		
		('Call of Duty: Modern Warfare', '20', '9.99', 'Game', 'https://upload.wikimedia.org/wikipedia/en/thumb/5/5f/Call_of_Duty_4_Modern_Warfare.jpg/250px-Call_of_Duty_4_Modern_Warfare.jpg', 'A military shooter featuring modern combat and intense missions.'),
		('Minecraft', '25', '7.99', 'Game', 'https://minecraft.wiki/images/thumb/Minecraft_xbox360_retail_cover.jpg/800px-Minecraft_xbox360_retail_cover.jpg?1cb57', 'A sandbox game where players build, explore, and survive in a block world.'),
		('The Legend of Zelda: Twilight Princess', '8', '7.99', 'Game', 'https://upload.wikimedia.org/wikipedia/en/0/0e/The_Legend_of_Zelda_Twilight_Princess_Game_Cover.jpg', 'An adventure game where Link battles darkness in the Twilight Realm.'),
		('Madden NFL 08', '10', '4.99', 'Game', 'https://upload.wikimedia.org/wikipedia/en/4/4c/Madden_NFL_08_Coverart.png', 'A football simulation game featuring NFL teams and gameplay.'),
		('Spider-Man 2', '3', '3.99', 'Movie', 'https://upload.wikimedia.org/wikipedia/en/thumb/4/4e/Spider-Man_2_USA_poster.jpg/250px-Spider-Man_2_USA_poster.jpg', 'Spider-Man struggles to balance life while facing Doctor Octopus.'),
		('Rock Band 2', '6', '5.99', 'Game', 'https://upload.wikimedia.org/wikipedia/en/0/01/Rock_Band_2_Game_Cover.JPG', 'A rhythm game where players perform songs using instruments.');

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
