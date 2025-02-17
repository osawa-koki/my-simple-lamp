CREATE TABLE IF NOT EXISTS users (
  id VARCHAR(36) PRIMARY KEY CHECK (LENGTH(id) >= 8 AND id REGEXP '^[a-zA-Z0-9_\\-]+$'),
  password VARCHAR(255) NOT NULL,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE CHECK (email REGEXP '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$'),
  birthday DATE NOT NULL,
  comment TEXT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (id, password, name, email, birthday, comment)
SELECT 'user_user-1', 'encrypted_password', 'hogehoge', 'hoge@example.com', '1990-01-01', 'hello'
WHERE NOT EXISTS (SELECT 1 FROM users WHERE id = 'user_user-1');

INSERT INTO users (id, password, name, email, birthday, comment)
SELECT 'user_user-2', 'encrypted_password', 'foofoo', 'foo@example.com', '1985-05-15', 'welcome'
WHERE NOT EXISTS (SELECT 1 FROM users WHERE id = 'user_user-2');

INSERT INTO users (id, password, name, email, birthday, comment)
SELECT 'user_user-3', 'encrypted_password', 'barbar', 'bar@example.com', '1995-12-31', NULL
WHERE NOT EXISTS (SELECT 1 FROM users WHERE id = 'user_user-3');
