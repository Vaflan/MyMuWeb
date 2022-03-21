if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_comment]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_comment]


CREATE TABLE [dbo].[MMW_comment] (
	[c_id] [int] IDENTITY (1, 1) NOT NULL ,
	[c_id_blog] [nvarchar] (50) COLLATE Chinese_PRC_CI_AS NULL ,
	[c_id_code] [nvarchar] (50) COLLATE Chinese_PRC_CI_AS NULL ,
	[c_char] [nvarchar] (50) COLLATE Chinese_PRC_CI_AS NULL ,
	[c_text] [text] COLLATE Chinese_PRC_CI_AS NULL ,
	[c_date] [nvarchar] (50) COLLATE Chinese_PRC_CI_AS NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]





if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_forum]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_forum]


CREATE TABLE [dbo].[MMW_forum] (
	[f_id] [nvarchar] (50) COLLATE Chinese_PRC_CI_AS NULL ,
	[f_char] [nvarchar] (50) COLLATE Chinese_PRC_CI_AS NULL ,
	[f_title] [nvarchar] (50) COLLATE Chinese_PRC_CI_AS NULL ,
	[f_text] [text] COLLATE Chinese_PRC_CI_AS NULL ,
	[f_date] [int] NULL ,
	[f_lostchar] [nvarchar] (50) COLLATE Chinese_PRC_CI_AS NULL ,
	[f_status] [int] NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]





if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_links]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_links]


CREATE TABLE [dbo].[MMW_links] (
	[link_name] [varchar] (100) COLLATE Chinese_PRC_CI_AS NULL ,
	[link_address] [text] COLLATE Chinese_PRC_CI_AS NULL ,
	[link_description] [text] COLLATE Chinese_PRC_CI_AS NULL ,
	[link_id] [varchar] (100) COLLATE Chinese_PRC_CI_AS NULL ,
	[link_date] [varchar] (100) COLLATE Chinese_PRC_CI_AS NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]





if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_news]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_news]


CREATE TABLE [dbo].[MMW_news] (
	[news_id] [nvarchar] (100) COLLATE Chinese_PRC_CI_AS NULL ,
	[news_title] [nvarchar] (100) COLLATE Chinese_PRC_CI_AS NULL ,
	[news_category] [nvarchar] (100) COLLATE Chinese_PRC_CI_AS NULL ,
	[news_eng] [text] COLLATE Chinese_PRC_CI_AS NULL ,
	[news_rus] [text] COLLATE Chinese_PRC_CI_AS NULL ,
	[news_autor] [nvarchar] (100) COLLATE Chinese_PRC_CI_AS NULL ,
	[news_date] [nvarchar] (100) COLLATE Chinese_PRC_CI_AS NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]






if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_servers]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_servers]


CREATE TABLE [dbo].[MMW_servers] (
	[name] [nvarchar] (100) COLLATE Chinese_PRC_CI_AS NULL ,
	[experience] [nvarchar] (100) COLLATE Chinese_PRC_CI_AS NULL ,
	[drops] [nvarchar] (100) COLLATE Chinese_PRC_CI_AS NULL ,
	[gsport] [nvarchar] (100) COLLATE Chinese_PRC_CI_AS NULL ,
	[ip] [nvarchar] (100) COLLATE Chinese_PRC_CI_AS NULL ,
	[display_order] [nvarchar] (100) COLLATE Chinese_PRC_CI_AS NULL ,
	[version] [nvarchar] (100) COLLATE Chinese_PRC_CI_AS NULL ,
	[type] [nvarchar] (50) COLLATE Chinese_PRC_CI_AS NULL 
) ON [PRIMARY]






if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_votemain]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_votemain]


CREATE TABLE [dbo].[MMW_votemain] (
	[ID] [int] IDENTITY (1, 1) NOT NULL ,
	[question] [nvarchar] (100) COLLATE Chinese_PRC_CI_AS NULL ,
	[answer1] [nvarchar] (50) COLLATE Chinese_PRC_CI_AS NULL ,
	[answer2] [nvarchar] (50) COLLATE Chinese_PRC_CI_AS NULL ,
	[answer3] [nvarchar] (50) COLLATE Chinese_PRC_CI_AS NULL ,
	[answer4] [nvarchar] (50) COLLATE Chinese_PRC_CI_AS NULL ,
	[answer5] [nvarchar] (50) COLLATE Chinese_PRC_CI_AS NULL ,
	[answer6] [nvarchar] (50) COLLATE Chinese_PRC_CI_AS NULL ,
	[add_date] [nvarchar] (11) COLLATE Chinese_PRC_CI_AS NULL 
) ON [PRIMARY]






if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_voterow]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_voterow]


CREATE TABLE [dbo].[MMW_voterow] (
	[ID_vote] [int] NULL ,
	[who] [nvarchar] (15) COLLATE Chinese_PRC_CI_AS NULL ,
	[answer] [int] NULL 
) ON [PRIMARY]
