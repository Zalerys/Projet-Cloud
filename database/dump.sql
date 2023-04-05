create table Servers
(
    id   int auto_increment
        primary key,
    name varchar(255) not null,
    constraint Servers_uniques
        unique (name)
);

create table Users
(
    id             int auto_increment
        primary key,
    username       varchar(255) not null,
    email          varchar(255) not null,
    password       varchar(255) not null,
    public_ssh_key text         null,
    constraint Users_uniques
        unique (username, email)
);

create table UsersServers
(
    user_id   int not null,
    server_id int not null,
    primary key (user_id, server_id),
    constraint UsersServers_Servers_id_fk
        foreign key (server_id) references Servers (id)
            on update cascade on delete cascade,
    constraint UsersServers_Users_id_fk
        foreign key (user_id) references Users (id)
            on update cascade on delete cascade
);

