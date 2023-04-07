create table Servers
(
    id                  int auto_increment
        primary key,
    name                varchar(255)                          not null,
    storage_size        int       default 5                   not null comment 'in gigabytes',
    backups_folder_path varchar(255)                          not null,
    auto_backups_time   time                                  null,
    created_at          timestamp default current_timestamp() not null,
    constraint Servers_uniques
        unique (name)
);

create table `Databases`
(
    id         int auto_increment
        primary key,
    name       varchar(255)                          not null,
    server_id  int                                   not null,
    created_at timestamp default current_timestamp() not null,
    constraint Databases_Servers_id_fk
        foreign key (server_id) references Servers (id)
            on update cascade on delete cascade
);

create index Databases_Servers_name_fk
    on `Databases` (name);

create table DatabasesUsers
(
    id          int auto_increment
        primary key,
    username    varchar(255)                          not null,
    password    varchar(255)                          not null,
    database_id int                                   not null,
    created_at  timestamp default current_timestamp() not null,
    constraint DatabasesUsers_Databases_id_fk
        foreign key (database_id) references `Databases` (id)
            on update cascade on delete cascade
);

create table Users
(
    id             int auto_increment
        primary key,
    username       varchar(255)                          not null,
    email          varchar(255)                          not null,
    password       varchar(255)                          not null,
    public_ssh_key text                                  null,
    created_at     timestamp default current_timestamp() not null,
    constraint Users_uniques
        unique (username, email)
);

create table ServersUsers
(
    user_id    int                                   not null,
    server_id  int                                   not null,
    created_at timestamp default current_timestamp() not null,
    primary key (user_id, server_id),
    constraint UsersServers_Servers_id_fk
        foreign key (server_id) references Servers (id)
            on update cascade on delete cascade,
    constraint UsersServers_Users_id_fk
        foreign key (user_id) references Users (id)
            on update cascade on delete cascade
);

