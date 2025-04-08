CREATE TABLE recipes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    prep_time INT,
    difficulty INT CHECK (difficulty BETWEEN 1 AND 3),
    vegetarian BOOLEAN
);

CREATE TABLE ratings (
    id SERIAL PRIMARY KEY,
    recipe_id INT REFERENCES recipes(id),
    score INT CHECK (score BETWEEN 1 AND 5)
);