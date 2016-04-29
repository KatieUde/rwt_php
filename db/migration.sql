CREATE DATABASE rwtheatre;

\c rwtheatre

CREATE TABLE movies (id SERIAL PRIMARY KEY, omdb_id VARCHAR (20), omdb_poster TEXT, youtube TEXT, playing_now BOOLEAN, upcoming BOOLEAN, VARCHAR (5));

CREATE TABLE ticket_details (id SERIAL PRIMARY KEY, ticket_style TEXT, ticket_cost INTEGER);

CREATE TABLE ticket_purchases (id SERIAL PRIMARY KEY, );

CREATE TABLE tickets (id SERIAL PRIMARY KEY,);

CREATE TABLE viewing_rooms (id SERIAL PRIMARY KEY,);

CREATE TABLE viewings (id SERIAL PRIMARY KEY,);
