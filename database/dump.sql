create table doctrine_migration_versions
(
    version        varchar(191) not null
        primary key,
    executed_at    datetime     null,
    execution_time int          null
)
    collate = utf8mb3_unicode_ci;

create table server
(
    id                  int auto_increment
        primary key,
    name                varchar(255) not null,
    storage_size        double       null,
    backups_folder_path varchar(255) null,
    auto_backups_time   time         null comment '(DC2Type:time_immutable)',
    created_at          datetime     not null comment '(DC2Type:datetime_immutable)',
    constraint UNIQ_5A6DD5F65E237E06
        unique (name)
)
    collate = utf8mb4_unicode_ci;

create table program_db
(
    id         int auto_increment
        primary key,
    server_id  int          not null,
    name       varchar(255) not null,
    created_at datetime     not null comment '(DC2Type:datetime_immutable)',
    constraint UNIQ_6275DC725E237E06
        unique (name),
    constraint FK_6275DC721844E6B7
        foreign key (server_id) references server (id)
)
    collate = utf8mb4_unicode_ci;

create index IDX_6275DC721844E6B7
    on program_db (server_id);

create table user
(
    id             int auto_increment
        primary key,
    username       varchar(180)   not null,
    roles          longtext       not null comment '(DC2Type:json)',
    password       varchar(255)   not null,
    email          varchar(255)   not null,
    public_ssh_key varchar(10000) null,
    created_at     datetime       not null comment '(DC2Type:datetime_immutable)',
    constraint UNIQ_8D93D649E7927C74
        unique (email),
    constraint UNIQ_8D93D649F85E0677
        unique (username)
)
    collate = utf8mb4_unicode_ci;

create table database_user
(
    database_id int not null,
    user_id     int not null,
    primary key (database_id, user_id),
    constraint FK_FFEE9405A76ED395
        foreign key (user_id) references user (id)
            on delete cascade,
    constraint FK_FFEE9405F0AA09DB
        foreign key (database_id) references program_db (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index IDX_FFEE9405A76ED395
    on database_user (user_id);

create index IDX_FFEE9405F0AA09DB
    on database_user (database_id);

create table server_user
(
    server_id int not null,
    user_id   int not null,
    primary key (server_id, user_id),
    constraint FK_613A7A91844E6B7
        foreign key (server_id) references server (id)
            on delete cascade,
    constraint FK_613A7A9A76ED395
        foreign key (user_id) references user (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index IDX_613A7A91844E6B7
    on server_user (server_id);

create index IDX_613A7A9A76ED395
    on server_user (user_id);

