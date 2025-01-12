/*Creamos la tabla de módulos*/
CREATE TABLE Modules (
	id INT NOT NULL AUTO_INCREMENT, 
    name VARCHAR(100) NOT NULL,
    active boolean NOT NULL,
    create_user varchar(100) NOT NULL,
    create_date timestamp NOT NULL,
    modified_user varchar(100),
    modified_date timestamp,
    PRIMARY KEY (id));
/*Creamos la tabla de roles*/
CREATE TABLE Roles (
	id INT NOT NULL AUTO_INCREMENT, 
    name VARCHAR(100) NOT NULL,
    active boolean NOT NULL,
    create_user varchar(100) NOT NULL,
    create_date timestamp NOT NULL,
    modified_user varchar(100),
    modified_date timestamp,
    PRIMARY KEY (id));
/*Creamos la tabla de permisos*/
CREATE TABLE Permissions (
	id INT NOT NULL AUTO_INCREMENT, 
    id_role int NOT NULL,
    id_module int NOT NULL,
    per_read boolean,
    per_create boolean,
    per_update boolean,
    per_delete boolean,
    per_filter boolean,
    per_report boolean,
    active boolean NOT NULL,
    create_user varchar(100) NOT NULL,
    create_date timestamp NOT NULL,
    modified_user varchar(100),
    modified_date timestamp,
    PRIMARY KEY (id),
    foreign key(id_role) REFERENCES Roles(id),
    foreign key(id_module) REFERENCES Modules(id));
/*Creamos la tabla de personas*/
CREATE TABLE Persons (
	id INT NOT NULL AUTO_INCREMENT,     
    full_name varchar(100) NOT NULL,
    address varchar(500),
    email varchar(250) NOT NULL UNIQUE,
    phone varchar(30) NOT NULL,
    iso_country varchar(2),
    active boolean NOT NULL,
    create_user varchar(100) NOT NULL,
    create_date timestamp NOT NULL,
    modified_user varchar(100),
    modified_date timestamp,
    PRIMARY KEY (id));
/*Creamos la tabla de usuarios*/
CREATE TABLE Users (
	id INT NOT NULL AUTO_INCREMENT,     
    login varchar(100) NOT NULL UNIQUE,
    password varchar(100) NOT NULL,
    id_person int NOT NULL,
    id_role int NOT NULL,
    active boolean NOT NULL,
    create_user varchar(100) NOT NULL,
    create_date timestamp NOT NULL,
    modified_user varchar(100),
    modified_date timestamp,
    PRIMARY KEY (id),
    foreign key(id_role) REFERENCES Roles(id),
    foreign key(id_person) REFERENCES Persons(id));
/*Creamos la tabla de alojamientos*/
CREATE TABLE Accommodations (
	id INT NOT NULL AUTO_INCREMENT,     
    id_user int NOT NULL,
    name varchar(100) NOT NULL,
    address varchar(250) NOT NULL,
    email_contact varchar(250),
    phone varchar(20),
    iso_country varchar(2),
    description varchar(500),
    active boolean NOT NULL,
    create_user varchar(100) NOT NULL,
    create_date timestamp NOT NULL,
    modified_user varchar(100),
    modified_date timestamp,
    PRIMARY KEY (id),
    foreign key(id_user) REFERENCES Users(id));
/*Creamos la tabla de servicios*/
CREATE TABLE Services (
	id INT NOT NULL AUTO_INCREMENT,         
    name varchar(100) NOT NULL,
    fa_icon varchar(20) NOT NULL,
    type varchar(20),
    active boolean NOT NULL,
    create_user varchar(100) NOT NULL,
    create_date timestamp NOT NULL,
    modified_user varchar(100),
    modified_date timestamp,
    PRIMARY KEY (id));
/*Creamos la tabla de servicios del alojamiento*/
CREATE TABLE AccommodationServices (
	id INT NOT NULL AUTO_INCREMENT,     
    id_service int NOT NULL,
    id_accommodation int NOT NULL,    
    active boolean NOT NULL,
    create_user varchar(100) NOT NULL,
    create_date timestamp NOT NULL,
    modified_user varchar(100),
    modified_date timestamp,
    PRIMARY KEY (id),
    foreign key(id_service) REFERENCES Services(id),
    foreign key(id_accommodation) REFERENCES Accommodations(id));
/*Creamos la tabla de habitaciones del alojamiento*/
CREATE TABLE AccommodationRooms (
	id INT NOT NULL AUTO_INCREMENT,     
    id_accommodation int NOT NULL,    
    bed_type varchar(20) NOT NULL,
    max_host int NOT NULL,
    room_number varchar(5),
    description varchar(500),
    active boolean NOT NULL,
    create_user varchar(100) NOT NULL,
    create_date timestamp NOT NULL,
    modified_user varchar(100),
    modified_date timestamp,
    PRIMARY KEY (id),
    foreign key(id_accommodation) REFERENCES Accommodations(id));   
/*Creamos la tabla de galeria del alojamiento*/
CREATE TABLE AccommodationGalleries (
	id INT NOT NULL AUTO_INCREMENT,     
    id_accommodation int NOT NULL,    
    url_photo varchar(250) NOT NULL,
    description varchar(500),
    active boolean NOT NULL,
    create_user varchar(100) NOT NULL,
    create_date timestamp NOT NULL,
    modified_user varchar(100),
    modified_date timestamp,
    PRIMARY KEY (id),
    foreign key(id_accommodation) REFERENCES Accommodations(id));   
/*Creamos la tabla de servicios de habitacion del alojamiento*/
CREATE TABLE AccommodationRoomServices (
	id INT NOT NULL AUTO_INCREMENT,     
    id_accommodation int NOT NULL,    
    id_service int NOT NULL,   
    active boolean NOT NULL,
    create_user varchar(100) NOT NULL,
    create_date timestamp NOT NULL,
    modified_user varchar(100),
    modified_date timestamp,
    PRIMARY KEY (id),
    foreign key(id_accommodation) REFERENCES Accommodations(id),
    foreign key(id_service) REFERENCES Services(id));    
/*Creamos la tabla de estados de la reserva*/
CREATE TABLE Status (
	id INT NOT NULL AUTO_INCREMENT, 
    name VARCHAR(20) NOT NULL,
    active boolean NOT NULL,
    create_user varchar(100) NOT NULL,
    create_date timestamp NOT NULL,
    modified_user varchar(100),
    modified_date timestamp,
    PRIMARY KEY (id));
/*Creamos la tabla de reservas*/
CREATE TABLE Bookings (
	id INT NOT NULL AUTO_INCREMENT,     
    id_accommodation_room int NOT NULL,    
    id_user int NOT NULL,
    id_status int NOT NULL,
    check_in date NOT NULL,
    check_out date NOT NULL,
    comments varchar(500),
    active boolean NOT NULL,
    create_user varchar(100) NOT NULL,
    create_date timestamp NOT NULL,
    modified_user varchar(100),
    modified_date timestamp,
    PRIMARY KEY (id),
    foreign key(id_accommodation_room) REFERENCES AccommodationRooms(id),
    foreign key(id_user) REFERENCES Users(id),
    foreign key(id_status) REFERENCES Status(id));        