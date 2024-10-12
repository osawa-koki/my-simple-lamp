CREATE TABLE IF NOT EXISTS sessions (
  id VARCHAR(36) PRIMARY KEY,
  user_id VARCHAR(36),
  ip_address VARCHAR(45) NOT NULL,
  user_agent VARCHAR(1024) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  valid_until DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT valid_until_check CHECK (valid_until > created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO sessions (id, user_id, ip_address, user_agent, valid_until)
SELECT 'session_session-1', 'user_user-1', '192.168.1.1', 'Mozilla/5.0', '2024-12-31 23:59:59'
WHERE NOT EXISTS (SELECT 1 FROM sessions WHERE id = 'session_session-1');

INSERT INTO sessions (id, user_id, ip_address, user_agent, valid_until)
SELECT 'session_session-2', 'user_user-2', '192.168.1.2', 'Mozilla/5.0', '2024-12-31 23:59:59'
WHERE NOT EXISTS (SELECT 1 FROM sessions WHERE id = 'session_session-2');

INSERT INTO sessions (id, user_id, ip_address, user_agent, valid_until)
SELECT 'session_session-3', 'user_user-3', '192.168.1.3', 'Mozilla/5.0', '2024-12-31 23:59:59'
WHERE NOT EXISTS (SELECT 1 FROM sessions WHERE id = 'session_session-3');
