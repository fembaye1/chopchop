DROP TABLE IF EXISTS chop_users CASCADE;
DROP TABLE IF EXISTS chop_recipes CASCADE;
DROP TABLE IF EXISTS chop_favorites CASCADE;

-- users table
CREATE TABLE chop_users (
  id SERIAL PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  password_hash TEXT NOT NULL,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT now()
);

-- recipes table
CREATE TABLE chop_recipes (
  id SERIAL PRIMARY KEY,
  -- creating foreign key requirement, so makes sure that every recipes.user_id must exist in the users table
  user_id INTEGER NOT NULL REFERENCES chop_users(id) ON DELETE CASCADE,
  title VARCHAR(200) NOT NULL,
  image_path VARCHAR(250),
  genre VARCHAR(150) NOT NULL,
  time_takes INTEGER NOT NULL,
  instructions TEXT NOT NULL,
  ingredients JSONB DEFAULT '[]'::jsonb,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT now()
);

-- favorites table
CREATE TABLE chop_favorites (
  id SERIAL PRIMARY KEY,
  -- same idea as recipes, but also with recipes to favorites
  user_id INTEGER NOT NULL REFERENCES chop_users(id) ON DELETE CASCADE,
  recipe_id INTEGER NOT NULL REFERENCES chop_recipes(id) ON DELETE CASCADE,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT now(),
  UNIQUE (user_id, recipe_id)
);
