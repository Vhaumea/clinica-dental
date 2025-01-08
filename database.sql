CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role ENUM('Recepcionista', 'Dentista', 'Admin') DEFAULT 'Recepcionista',
    rut VARCHAR(255) UNIQUE,
    name VARCHAR(100),
    apellido_p VARCHAR(200),
    apellido_m VARCHAR(200),
    fecha_nacimiento DATE,
    sexo ENUM('Masculino', 'Femenino'),
    email VARCHAR(255) UNIQUE,
    phone VARCHAR(15),
    region VARCHAR(255),
    comuna VARCHAR(255),
    direccion VARCHAR(255),
    password VARCHAR(255),
    image VARCHAR(255) DEFAULT NULL,
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    remember_token VARCHAR(100) DEFAULT NULL
);

CREATE TABLE pacientes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    rut VARCHAR(255) UNIQUE,
    nombre VARCHAR(255),
    apellido_p VARCHAR(200),
    apellido_m VARCHAR(200),
    sexo ENUM('Masculino', 'Femenino'),
    birth DATE,
    telefono VARCHAR(255),
    email VARCHAR(255) DEFAULT NULL,
    region VARCHAR(255),
    comuna VARCHAR(255),
    direccion VARCHAR(255),
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE horarios_laborales (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    start_datetime DATETIME DEFAULT NULL,
    end_datetime DATETIME DEFAULT NULL,
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    notes TEXT DEFAULT NULL,
    schedule_type ENUM('Normal', 'Extra') DEFAULT 'Normal',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE citas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    paciente_id BIGINT UNSIGNED,
    user_id BIGINT UNSIGNED,
    presupuesto_id BIGINT UNSIGNED DEFAULT NULL,
    fecha DATE,
    hora TIME,
    motivo TEXT DEFAULT NULL,
    origen TEXT DEFAULT NULL,
    medio ENUM('Presencial', 'Telefono', 'Whatsapp', 'Facebook'),
    estado ENUM('Pendiente', 'Confirmada', 'Cancelada', 'Completada', 'No asistio') DEFAULT 'Pendiente',
    observaciones TEXT DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (paciente_id) REFERENCES pacientes(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (presupuesto_id) REFERENCES presupuesto(id) ON DELETE SET NULL
);

CREATE TABLE presupuesto (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    paciente_id BIGINT UNSIGNED NOT NULL,
    subtotal INT NOT NULL,
    descuento INT NOT NULL,
    total_final INT NOT NULL,
    saldo_pendiente DECIMAL(10, 2),
    fecha DATE NOT NULL,
    estado ENUM('Pendiente', 'En proceso', 'Rechazado', 'Completado') DEFAULT 'Pendiente',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

     FOREIGN KEY (paciente_id) REFERENCES pacientes(id)
);

CREATE TABLE detalle_presupuesto (
   id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   presupuesto_id BIGINT UNSIGNED NOT NULL, 
   pieza VARCHAR(10), 
   tratamiento VARCHAR(500), 
   tratamiento_estado ENUM('Pendiente', 'En proceso', 'Completado') DEFAULT 'Pendiente', 
   precio DECIMAL(10, 2), 
   observaciones VARCHAR(255) DEFAULT NULL, 
   created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP, 
   updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

   FOREIGN KEY (presupuesto_id) REFERENCES presupuesto(id) ON DELETE CASCADE
);

CREATE TABLE notas_evolucion (
   id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
   cita_id BIGINT UNSIGNED NOT NULL, 
   descripcion TEXT NOT NULL, 
   fecha_nota DATETIME DEFAULT CURRENT_TIMESTAMP, 
   observaciones_evolucion TEXT DEFAULT NULL, 
   estado_nota ENUM('Activo', 'Inactivo') DEFAULT 'Activo', 
   created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP, 
   updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

   FOREIGN KEY (cita_id) REFERENCES citas(id) ON DELETE CASCADE
);

CREATE TABLE abonos (
   id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
   presupuesto_id BIGINT UNSIGNED NOT NULL, 
   monto_abono INT NOT NULL, 
   fecha_abono DATETIME DEFAULT CURRENT_TIMESTAMP, 
   metodo_pago ENUM('Efectivo', 'Tarjeta Crédito', 'Tarjeta Débito', 'Transferencia'), 
   notas VARCHAR(255) DEFAULT NULL, 
   created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP, 
   updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

   FOREIGN KEY (presupuesto_id) REFERENCES presupuesto(id)
);

CREATE TABLE fichas_clinicas (
   id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
   paciente_id BIGINT UNSIGNED NOT NULL, 
   medicamentos VARCHAR(255) DEFAULT NULL, 
   alergias VARCHAR(255) DEFAULT NULL, 
   embarazo BOOLEAN DEFAULT FALSE, 
   tiempo_gestacion INT DEFAULT NULL, 
   enfermedades_sistemicas BOOLEAN DEFAULT FALSE, 
   hipertension BOOLEAN DEFAULT FALSE, 
   diabetes BOOLEAN DEFAULT FALSE, 
   otros VARCHAR(255) DEFAULT NULL, 
   reaccion_alergica_medicamento VARCHAR(255) DEFAULT NULL, 
   reaccion_alergica_anestesia VARCHAR(255) DEFAULT NULL, 
   observaciones TEXT DEFAULT NULL, 
   created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP, 
   updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  FOREIGN KEY (paciente_id) REFERENCES pacientes(id) ON DELETE CASCADE
);
