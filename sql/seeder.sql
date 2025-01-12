/*Creamos el seeder para los modulos del sistema*/
INSERT INTO Modules (name, active, create_user, create_date, modified_user, modified_date) values 
	('Config',1,'Administrator',curdate(),'Administrator',curdate()),
    ('User',1,'Administrator',curdate(),'Administrator',curdate()),
    ('Accommodation',1,'Administrator',curdate(),'Administrator',curdate()),
    ('Booking',1,'Administrator',curdate(),'Administrator',curdate());
    
/*Creamos el seeder para los Roles del sistema*/
INSERT INTO Roles (name, active, create_user, create_date, modified_user, modified_date) values 
	('Administrator',1,'Administrator',curdate(),'Administrator',curdate()),
    ('Partner',1,'Administrator',curdate(),'Administrator',curdate()),
    ('Client',1,'Administrator',curdate(),'Administrator',curdate());

/*Creamos el seeder para los permisos del sistema*/    
INSERT INTO Permissions (id_role, id_module, per_read, per_create, per_update, per_delete, per_filter, per_report, active, create_user, create_date, modified_user, modified_date) values 
	(1,1,1,1,1,1,1,1,1,'Administrator',curdate(),'Administrator',curdate()),
    (1,2,1,1,1,1,1,1,1,'Administrator',curdate(),'Administrator',curdate()),
    (1,3,1,1,1,1,1,1,1,'Administrator',curdate(),'Administrator',curdate()),
    (1,4,1,1,1,1,1,1,1,'Administrator',curdate(),'Administrator',curdate()),
    (2,3,1,1,1,0,1,1,1,'Administrator',curdate(),'Administrator',curdate()),
    (2,4,1,0,0,0,1,1,1,'Administrator',curdate(),'Administrator',curdate()),
    (3,4,1,1,1,0,1,1,1,'Administrator',curdate(),'Administrator',curdate());

update Users set id_role=1 where id=2;