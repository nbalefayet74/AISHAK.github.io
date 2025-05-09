-- scripts/01_test.sql
CREATE TABLE IF NOT EXISTS test_ci (
  id INT AUTO_INCREMENT PRIMARY KEY,
  label VARCHAR(50)
);
INSERT INTO test_ci(label) VALUES ('Import OK depuis GitHub');
