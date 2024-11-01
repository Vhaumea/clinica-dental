CREATE DATABASE IF NOT EXISTS clinica_dental;
USE clinica_dental;

CREATE TABLE IF NOT EXISTS users (
    id              INT AUTO_INCREMENT NOT NULL,
    role            ENUM('Recepcionista', 'Dentista', 'Admin') NOT NULL,
    rut             VARCHAR(12) NOT NULL UNIQUE,
    descuento       DECIMAL(5, 2) DEFAULT 0.00, 
    nombre          VARCHAR(100) NOT NULL,
    apellido        VARCHAR(200) NOT NULL,
    sexo            ENUM('Masculino', 'Femenino', 'Otro') NOT NULL,
    email           VARCHAR(255) NOT NULL,
    phone           VARCHAR(15) NOT NULL,
    direccion       VARCHAR(255) NOT NULL,
    password        VARCHAR(255) NOT NULL,
    image           VARCHAR(255) ,
    estado          ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at      DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    remember_token  VARCHAR(255),
    CONSTRAINT pk_users PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pacientes (
    id              INT AUTO_INCREMENT UNIQUE NOT NULL,
    rut             VARCHAR(12) NOT NULL UNIQUE,
    name            VARCHAR(100) NOT NULL,
    surname         VARCHAR(200) NOT NULL,
    sexo            ENUM('Masculino', 'Femenino', 'Otro') NOT NULL,
    birth           DATE NOT NULL,
    telfono         VARCHAR(15) NOT NULL,
    email           VARCHAR(255) NOT NULL,
    direccion         VARCHAR(255) NOT NULL,
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
    updated_at      DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT pk_pacientes PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS horarios_trabajo (
    id              INT AUTO_INCREMENT NOT NULL,
    user_id         INT NOT NULL, 
    dia_semana      ENUM('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo') NOT NULL,
    hora_inicio     TIME NOT NULL, 
    hora_fin        TIME NOT NULL,
    estado          ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at      DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT pk_horarios PRIMARY KEY(id),
    CONSTRAINT fk_horarios_users FOREIGN KEY (user_id) REFERENCES users(id) 
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS insumos (
    id              INT AUTO_INCREMENT NOT NULL,
    nombre          VARCHAR(100) NOT NULL, 
    cantidad        INT NOT NULL DEFAULT 0, 
    estado          ENUM('Disponible', 'Agotado') DEFAULT 'Disponible',
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at      DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT pk_insumos PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS instrumentos (
    id              INT AUTO_INCREMENT NOT NULL,
    nombre          VARCHAR(100) NOT NULL, 
    cantidad        INT NOT NULL DEFAULT 0, 
    estado          ENUM('Disponible','En uso', 'En esterilizacion') DEFAULT 'Disponible',
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at      DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT pk_instrumentos PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS piezas_dentales (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id     INT NOT NULL,
    diente          VARCHAR(10) NOT NULL, 
    estado          ENUM('Sano', 'Con Caries', 'Tratado', 'Extraído') DEFAULT 'Sano',
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at      DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT fk_piezas_dentales_pacientes FOREIGN KEY (paciente_id) REFERENCES pacientes(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS periodontogramas (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id     INT NOT NULL,
    fecha           DATE NOT NULL,
    observaciones   VARCHAR(255),
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at      DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,

    CONSTRAINT fk_periodontogramas_pacientes FOREIGN KEY (paciente_id) REFERENCES pacientes(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS detalles_periodontograma (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    periodontograma_id  INT NOT NULL,
    pieza_id            INT NOT NULL,
    parte               ENUM('Superior', 'Inferior') NOT NULL, 
    movilidad_implante   ENUM('0', '1', '2', '3'), 
    pronostico_individual VARCHAR(255), 
    surca               DECIMAL(5, 2), 
    sangrado            ENUM('Sí', 'No'), 
    supuracion          ENUM('Sí', 'No'), 
    placa               ENUM('Sí', 'No'), 
    anchura_encia       DECIMAL(5, 2), 
    margen_gingival     DECIMAL(5, 2), 
    profundidad_sondaje DECIMAL(5, 2), 
    CONSTRAINT fk_detalles_periodontograma FOREIGN KEY (periodontograma_id) REFERENCES periodontogramas(id),
    CONSTRAINT fk_detalles_piezas FOREIGN KEY (pieza_id) REFERENCES piezas_dentales(id)
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS pruebas_vitalidad (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id         INT NOT NULL,
    fecha               DATE NOT NULL,
    pieza_id            INT NOT NULL,
    respuesta           ENUM('Vital', 'No Vital') NOT NULL,
    tipo_prueba         ENUM('Frío', 'Calor', 'Eléctrico') NOT NULL, 
    observaciones       VARCHAR(255), 
    created_at          DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at          DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT fk_pruebas_vitalidad_pacientes FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    CONSTRAINT fk_pruebas_vitalidad_piezas FOREIGN KEY (pieza_id) REFERENCES piezas_dentales(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS procedimientos (
    id              INT AUTO_INCREMENT NOT NULL,
    name            VARCHAR(100) NOT NULL,
    descripcion     VARCHAR(255) NOT NULL,
    duracion        INT NOT NULL, 
    precio          INT NOT NULL, 
    tipo            ENUM('Preventivo', 'Restaurativo', 'Estético', 'Quirúrgico') NOT NULL,
    notas           VARCHAR(255),
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at      DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT pk_procedimientos PRIMARY KEY(id)
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS procedimientos_instrumentos (
    instrumento_id       INT NOT NULL, 
    procedimiento_id     INT NOT NULL,
    total                DECIMAL(10, 2) NOT NULL,
    cantidad             INT DEFAULT 1,
    CONSTRAINT pk_procedimientos_instrumentos PRIMARY KEY (instrumento_id, procedimiento_id),
    CONSTRAINT fk_procedimientos_instrumentos_instrumentos FOREIGN KEY (instrumento_id) REFERENCES instrumentos(id),
    CONSTRAINT fk_procedimientos_instrumentos_procedimientos FOREIGN KEY (procedimiento_id) REFERENCES procedimientos(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS procedimiento_insumos (
    insumo_id       INT NOT NULL, 
    procedimiento_id     INT NOT NULL,
    total                DECIMAL(10, 2) NOT NULL,
    cantidad             INT DEFAULT 1,
    CONSTRAINT pk_insumos_procedimientos PRIMARY KEY (insumo_id, procedimiento_id),
    CONSTRAINT fk_insumos_procedimientos_insumos FOREIGN KEY (insumo_id) REFERENCES insumos(id),
    CONSTRAINT fk_insumos_procedimientos_procedimientos FOREIGN KEY (procedimiento_id) REFERENCES procedimientos(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tratamientos (
    id              INT AUTO_INCREMENT NOT NULL,
    paciente_id     INT NOT NULL,
    user_id         INT NOT NULL,
    name            VARCHAR(100) NOT NULL,
    descripcion     VARCHAR(255) NOT NULL,
    total           INT NOT NULL, 
    tipo            ENUM('Preventivo', 'Restaurativo', 'Estético', 'Quirúrgico') NOT NULL,
    notas           VARCHAR(255),
    estado          ENUM('activo', 'completado', 'cancelado') DEFAULT 'activo',
    fecha_inicio    DATE NOT NULL,
    fecha_fin       DATE DEFAULT NULL,
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at      DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT pk_procedimientos PRIMARY KEY(id),
    CONSTRAINT fk_tratamientos_pacientes FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    CONSTRAINT fk_tratamientos_users FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS presupuestos (
    id                      INT AUTO_INCREMENT NOT NULL,
    paciente_id             INT NOT NULL,
    tratamiento_id          INT NOT NULL,
    total                   INT NOT NULL,
    fecha                   INT,
    saldo_pendiente DECIMAL(10, 2) NOT NULL,  
    estado ENUM('pendiente', 'aprobado', 'rechazado') DEFAULT 'pendiente',
    CONSTRAINT pk_presupuestos PRIMARY KEY(id),
    CONSTRAINT fk_presupuestos_pacientes FOREIGN KEY(paciente_id) REFERENCES pacientes(id),
    CONSTRAINT fk_presupuestos_tratamientos FOREIGN KEY(tratamiento_id) REFERENCES tratamientos(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tratamientos_procedimientos (
    tratamiento_id       INT NOT NULL, 
    procedimiento_id     INT NOT NULL,
    total                DECIMAL(10, 2) NOT NULL,
    cantidad             INT DEFAULT 1,
    CONSTRAINT pk_tratamientos_procedimientos PRIMARY KEY (tratamiento_id, procedimiento_id),
    CONSTRAINT fk_tratamientos_procedimientos_tratamientos FOREIGN KEY (tratamiento_id) REFERENCES tratamientos(id),
    CONSTRAINT fk_tratamientos_procedimientos_procedimientos FOREIGN KEY (procedimiento_id) REFERENCES procedimientos(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS presupuestos_tratamiento (
    id                      INT AUTO_INCREMENT PRIMARY KEY,
    presupuesto_id          INT NOT NULL,
    tratamiento_id          INT NOT NULL,
    CONSTRAINT fk_presupuestos_tratamiento_presupuestos FOREIGN KEY(presupuesto_id) REFERENCES presupuestos(id),
    CONSTRAINT fk_presupuestos_tratamiento_tratamientos FOREIGN KEY(tratamiento_id) REFERENCES tratamientos(id)
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS tratamientos_piezas (
    tratamiento_id       INT NOT NULL, 
    pieza_id             INT,
    CONSTRAINT pk_tratamientos_piezas PRIMARY KEY (tratamiento_id, pieza_id),
    CONSTRAINT fk_tratamientos_piezas_tratamientos FOREIGN KEY (tratamiento_id) REFERENCES tratamientos(id),
    CONSTRAINT fk_tratamientos_piezas_piezas FOREIGN KEY (pieza_id) REFERENCES piezas_dentales(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS citas (
    id               INT AUTO_INCREMENT NOT NULL,
    paciente_id      INT NOT NULL,
    user_id          INT NOT NULL,
    fecha_Hora       DATETIME NOT NULL,
    motivo           VARCHAR(255),
    presupuesto_id   INT DEFAULT NULL, 
    estado           ENUM('Pendiente', 'Confirmada', 'Cancelada', 'Completada') DEFAULT 'Pendiente',
    notas            VARCHAR(255),
    created_at       DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at       DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT pk_citas PRIMARY KEY(id),
    CONSTRAINT fk_citas_pacientes FOREIGN KEY(paciente_id) REFERENCES pacientes(id),
    CONSTRAINT fk_citas_users FOREIGN KEY(user_id) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pagos (
    id                      INT AUTO_INCREMENT NOT NULL,
    presupuesto_id          INT NOT NULL,
    total                   DECIMAL(10, 2) NOT NULL,
    fecha_pago              DATETIME NOT NULL,
    metodo_pago             ENUM('Efectivo', 'Tarjeta Credito', 'Tarjeta Debito', 'Transferencia') NOT NULL,
    created_at              DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at              DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT pk_pagos PRIMARY KEY(id),
    CONSTRAINT fk_pagos_presupuestos FOREIGN KEY (presupuesto_id) REFERENCES presupuestos(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS abonos (
    id                      INT AUTO_INCREMENT NOT NULL,
    presupuesto_id          INT NOT NULL,
    monto                   DECIMAL(10, 2) NOT NULL,
    fecha_abono             DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
    metodo_pago             ENUM('Efectivo', 'Tarjeta Credito', 'Tarjeta Debito', 'Transferencia') NOT NULL,
    notas                   VARCHAR(255),
    CONSTRAINT pk_abonos PRIMARY KEY(id),
    CONSTRAINT fk_abonos_presupuestos FOREIGN KEY (presupuesto_id) REFERENCES presupuestos(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS fichasclinicas (
    id                      INT AUTO_INCREMENT NOT NULL,
    paciente_id             INT NOT NULL,
    antecedentes_medicos    VARCHAR(255),
    alergias                VARCHAR(255),
    medicamentos            VARCHAR(255),
    observaciones                   VARCHAR(255),
    created_at              DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at              DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT pk_fichasclinicas PRIMARY KEY(id),
    CONSTRAINT fk_fichasclinica_pacientes FOREIGN KEY(paciente_id) REFERENCES pacientes(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS historialclinico (
    id                      INT AUTO_INCREMENT NOT NULL,
    fichaclinica_id        INT NOT NULL,
    fecha_consulta          DATETIME NOT NULL,
    diagnóstico             VARCHAR(255),
    tratamiento             VARCHAR(255),
    evolución_clínica       VARCHAR(255),
    observaciones           VARCHAR(255),
    examenes                VARCHAR(255),
    created_at              DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at              DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT pk_historialclinico PRIMARY KEY(id),
    CONSTRAINT fk_historialclinico_fichasclinicas FOREIGN KEY(fichaclinica_id) REFERENCES fichasclinicas(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS recordatorios (
    id                   INT AUTO_INCREMENT NOT NULL,
    cita_id              INT NOT NULL, 
    Mensaje              VARCHAR(255) NOT NULL,
    Fecha_Hora_Envio     DATETIME NOT NULL,
    Estado               ENUM('Pendiente', 'Enviado', 'Cancelado') DEFAULT 'Pendiente',
    CONSTRAINT pk_recordatorios PRIMARY KEY(id),
    CONSTRAINT fk_recordatorios_citas FOREIGN KEY (cita_id) REFERENCES citas(id)
) ENGINE=InnoDB;
