CREATE DATABASE rwtheatre;

\c rwtheatre

CREATE TABLE movies (id SERIAL PRIMARY KEY, name TEXT, omdb_id VARCHAR (20), omdb_poster TEXT, youtube TEXT, playing_now BOOLEAN, upcoming BOOLEAN, rating VARCHAR (6));

CREATE TABLE ticket_details (id SERIAL PRIMARY KEY, ticket_style TEXT, ticket_cost INTEGER);

CREATE TABLE ticket_purchases (id SERIAL PRIMARY KEY, name VARCHAR (50), email VARCHAR(50), age_confirm BOOLEAN, cc_number INTEGER, cc_cvc INTEGER, cc_exp TEXT, final_cost INTEGER, zip_code INTEGER, movie_id INTEGER, viewing_id INTEGER);

CREATE TABLE tickets (id SERIAL PRIMARY KEY, viewing_id INTEGER REFERENCES viewings, ticket_detail_id INTEGER REFERENCES ticket_details, ticket_purchase_id INTEGER REFERENCES ticket_purchases);

CREATE TABLE viewing_rooms (id SERIAL PRIMARY KEY, room_number INTEGER, seat_max INTEGER);

CREATE TABLE viewings (id SERIAL PRIMARY KEY, movie_id INTEGER REFERENCES movies, viewing_room_id INTEGER REFERENCES viewing_rooms, view_time TIME, view_date DATE);
