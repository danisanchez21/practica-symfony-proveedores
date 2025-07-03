-- Crear tabla usuario (ya incluida)
CREATE TABLE IF NOT EXISTS usuario (
  id INT AUTO_INCREMENT NOT NULL,
  email VARCHAR(180) NOT NULL,
  roles JSON NOT NULL,
  password VARCHAR(255) NOT NULL,
  PRIMARY KEY(id),
  UNIQUE INDEX UNIQ_2265B05DE7927C74 (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar usuario admin si no existe
INSERT INTO usuario (email, roles, password)
SELECT * FROM (SELECT
  'admin@example.com',
  '["ROLE_ADMIN"]',
  '$argon2id$v=19$m=65536,t=4,p=1$DAvkV9aggpdii62rxvXoPA$6J3P526U9CuSSxiP43Sx1Qk6MGcmMiGzICy4ZIfU5n8'
) AS tmp
WHERE NOT EXISTS (
  SELECT 1 FROM usuario WHERE email = 'admin@example.com'
) LIMIT 1;

-- Crear tabla proveedor
CREATE TABLE IF NOT EXISTS proveedor (
  id INT AUTO_INCREMENT NOT NULL,
  nombre VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  telefono VARCHAR(20) NOT NULL,
  tipo ENUM('hotel', 'pista', 'complemento') NOT NULL,
  estado BOOLEAN NOT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

