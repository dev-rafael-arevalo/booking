delete from Users where id=1;
ALTER TABLE Users AUTO_INCREMENT = 1;
delete from Persons where id=1;
ALTER TABLE Persons AUTO_INCREMENT = 1;

select * from Persons;
select * from Users;