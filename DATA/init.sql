CREATE TABLE test_table (
  id SERIAL PRIMARY KEY,
  nom VARCHAR(100),
  description TEXT
);

INSERT INTO test_table (nom, description)
VALUES ('Premier test', 'Insertion test depuis init.sql');