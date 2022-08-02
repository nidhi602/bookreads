create database bookreads;
use bookreads;

create table user (	
	name 			varchar(50) not null,
	age 			int,
    gender 			char(1),
    email 			varchar(50) not null,
    username 		varchar(20) not null,
    password 		varchar(255) not null,
    primary key (username));
    
create table book (
	book_id			varchar(5),
    cover			varchar(50),
	title			varchar(50) not null,
    author			varchar(50),
    genre			varchar(20),
    primary key(book_id));

create table user_book (
	username		varchar(20),
    book_id			varchar(5),
    shelf			varchar(50),
    rating			int,
    primary key(username, book_id),
    foreign key (username) references user(username) ON UPDATE CASCADE ON DELETE CASCADE,
    foreign key (book_id) references book(book_id) ON DELETE CASCADE,
    constraint chk_shelf check (shelf in ('read', 'to_read', 'currently_reading')));
    
drop procedure if exists get_avg_rating;

delimiter //
create procedure get_avg_rating(in book_id varchar(5))
begin
	select avg(rating)
    from user_book
    where user_book.book_id = book_id;
end //
delimiter ;
    
insert into book (book_id, cover, title, author, genre) values
	('B1','alice_in_wonderland.jpg', 'Alice in Wonderland','Lewis Carroll', 'Fantasy'),
    ('B2','gullivers_travels.jpg', 'Gulivers travels', 'Jonathan Swift', 'Fantasy'),
    ('B3','sense_and_sensibility.jpg', 'Sense and Sensibility','Jane Austin', 'Romance'),
    ('B4','wuthering_heights.jpg', 'Wuthering Heights', 'Emily Bronte', 'Romance'),
    ('B5','the_hunger_games.jpg', 'The Hunger Games','Suzanne Collins', 'Science Fiction'),
    ('B6','the_lightening_thief.jpg', 'The Lightning Thief','Rick Riordan', 'Fantasy'),
    ('B7','frankenstein.jpg', 'Frankenstein','Mary Shelley', 'Science Fiction'),
    ('B8','nineteen_eighty-four.jpg', 'Nineteen Eighty-Four', 'George Orwell', 'Science Fiction'),
    ('B9','atomic_habits.jpg', 'Atomic Habits', 'James Clear', 'Self Help'),
    ('B10','the_5am_club.jpg', 'The 5AM Club', 'Robin Sharma', 'Self Help'),
    ('B11','the_monk_who_sold_his_ferrari.jpg', 'The Monk Who Sold His Ferrari', 'Robin Sharma', 'Self Help'),
    ('B12','the_shining.jpg', 'The Shining', 'Stephen King', 'Horror'),
    ('B13','becoming.jpg', 'Becoming','Michelle Obama', 'Autobiography'),
	('B14','the_theory_of_everything.jpg', 'The Theory Of Everything','Stephen Hawking', 'Science'),
    ('B15','a_brief_history_of_time.jpg', 'A Brief History Of Time','Stephen Hawking', 'Science'),
	('B16','the_story_of_my_assassins.jpg', 'The Story Of My Assassins', 'Tarun J Tejpal','Mystery'),
    ('B17','the_girl_behind_the_glass.jpg', 'The Girl behind The Glass', 'Sumit Pramanik', 'Fantasy'),
    ('B18','betrayal.jpg', 'Betrayal', 'Danielle Steel', 'Romance'),
    ('B19','the_girl_and_the_ghost.jpg', 'The Girl and The Ghost ', 'Hannah Alkaf','Horror'),
    ('B20','the_girl_in_room_105.jpg', 'The Girl in Room 105', 'Chetan Bhagat','Mystery'),
    ('B21','an_american_tragedy.jpg', 'An American Tragedy', 'Theodore Dreiser','Romance'),
    ('B22','the_invisible_man.jpg', 'The Invisible Man', 'H. G. Wells','Science Fiction'),
    ('B23','a_portrait_of_the_artist.jpg', 'A Portrait of The Artist as A Young Man', 'James Joyce','Autobiography'),
    ('B24','the_glass_palace.jpg', 'The Glass Palace', 'Amitabh Ghosh','Romance'),
    ('B25','a_suitable_boy.jpg', 'A Suitable Boy', 'Vikram Seth','Romance');

-- insert into user values
-- 	('Admin 1', 22, 'F', 'admin001@bookreads.com','admin1','admin123'),
--     ('Admin 2', 22, 'F', 'admin002@bookreads.com','admin2','admin123');

-- insert into user_book values
-- 	('admin1','B1','to_read',null),
--     ('admin1','B2','read',3),
--     ('admin1','B5','read',4),
--     ('admin1','B9','currently_reading',null),
--     ('admin1','B22','read',3),
--     ('admin2','B2','read',2),
--     ('admin2','B5','read',3),
--     ('admin2','B6','to_read',null),
--     ('admin2','B15','currently_reading',null),
--     ('admin2','B22','read',2);

-- insert into user values
-- 	('Admin 3', 22, 'F', 'admin001@bookreads.com','admin3','admin123');
-- select * from user;
-- delete from user where username = 'admin3';

-- SELECT book_id, cover, title, author, genre_name FROM book, genre WHERE book.genre_id = genre.genre_id ORDER BY title;
-- call get_avg_rating('B25');
    
    
    
    