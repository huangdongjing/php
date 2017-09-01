create database aiyayablog charset=utf8;
GRANT ALL PRIVILEGES ON aiyayablog.* to 'baobao'@'%' identified by 'yaya19951021';
use aiyayablog;

--管理员表
--表名  前缀+逻辑表名
create table yy_admin(
admin_id int unsigned not null auto_increment,

admin_name varchar(32) not null default '',
admin_pwd char(32) comment '密码定长，md5加密后的密码,密文',

admin_role_id int unsigned not null default 0,

admin_last_login_time int comment '存时间戳？',
admin_last_login_ip int unsigned not null default 0,
primary key(admin_id)
)charset=utf8 engine=myisam;

--文章表
--执行的动作   添加  删除  更新
create table yy_article(
article_id int(11) primary key not null auto_increment,
article_title varchar(100) not null,
article_content text not null,
article_createtime int(20) not null,
article_lastmodifidtime int(20) not null,
article_comment_count int(5) not null default 0,
article_view_count int(7) not null default 0,
article_author varchar(20) not null
)charset=utf8 engine=InnoDB;

--文章分类表
--执行的动作   添加  删除  更新
create table yy_article_category(
category_id int(11) not null auto_increment,
category_name varchar(120) not null,
category_createtime int(11) not null,
article_count int(5) not null default 0,
primary key(category_id)
)charset=utf8 engine=InnoDB;

--文章  分类 关联 表（多对多的关系，新建一张表，方便查询）
--在提交文章表单的时候向里面插入数据
create table yy_ar_ca(
ar_ca_id int(11) not null primary key auto_increment,
article_id int(11) not null,
  category_id int(11) not null,

)
--为 yy_ar_ca字段添加约束
 foreign key(article_id) references yy_article(article_id)
  on delete cascade
  on update cascade,
  foreign key(category_id) references yy_article_category(category_id)
  on delete cascade
  on update cascade


--文章评论表
--执行的动作   添加（游客）  删除（管理员）
create table yy_article_comment(
comment_id int(10) not null auto_increment,
article_id int(10) not null,
comment_content text not null,
comment_uname varchar(40),
comment_time int(11) not null,
primary key(comment_id)
)charset=utf8 engine=InnoDB;
--为 yy_article_comment字段添加约束
foreign key(article_id) references yy_article(article_id) on delete cascade,



--相册表
--执行的动作   添加  删除
create table yy_photo(
photo_id int(11) auto_increment,
photo_name varchar(100),
photo_time int(11),
photo_storedir varchar(50),
primary key(photo_id)
)charset=utf8 engine=InnoDB;


--留言表

create table yy_message(
message_id int(11) auto_increment primary key,
message_ip int(10) not null default 0,
message_content text not null,
message_createtime int(20) not null default 0,
message_author varchar(20) not null default ''
)charset=utf8 engine=InnoDB;

















