if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_comment]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_comment]

CREATE TABLE [dbo].[MMW_comment] (
	[c_id] [int] IDENTITY (1, 1) NOT NULL ,
	[c_id_blog] [nvarchar] (50) NULL ,
	[c_id_code] [nvarchar] (50) NULL ,
	[c_char] [nvarchar] (50) NULL ,
	[c_text] [text] NULL ,
	[c_date] [nvarchar] (50) NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_forum]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_forum]

CREATE TABLE [dbo].[MMW_forum] (
	[f_id] [nvarchar] (50) NULL ,
	[f_char] [nvarchar] (50) NULL ,
	[f_title] [nvarchar] (50) NULL ,
	[f_text] [text] NULL ,
	[f_date] [int] NULL ,
	[f_lostchar] [nvarchar] (50) NULL ,
	[f_status] [int] NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_links]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_links]

CREATE TABLE [dbo].[MMW_links] (
	[link_name] [varchar] (100) NULL ,
	[link_address] [text] NULL ,
	[link_description] [text] NULL ,
	[link_size] [varchar] (100) NULL ,
	[link_id] [varchar] (100) NULL ,
	[link_date] [varchar] (100) NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_market]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_market]

CREATE TABLE [dbo].[MMW_market] (
	[item_id] [int] IDENTITY (1, 1) NOT NULL ,
	[item_char] [nvarchar] (10) NULL ,
	[item_category] [int] NULL ,
	[item_group] [int] NULL ,
	[item_style] [int] NULL ,
	[item_zen] [nvarchar] (100) NULL ,
	[item_hex] [nvarchar] (50) NULL ,
	[item_date] [int] NULL 
) ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_news]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_news]

CREATE TABLE [dbo].[MMW_news] (
	[news_id] [nvarchar] (100) NULL ,
	[news_title] [nvarchar] (100) NULL ,
	[news_category] [nvarchar] (100) NULL ,
	[news_row_1] [text] NULL ,
	[news_row_2] [text] NULL ,
	[news_row_3] [text] NULL ,
	[news_autor] [nvarchar] (100) NULL ,
	[news_date] [nvarchar] (100) NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_online]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_online]

CREATE TABLE [dbo].[MMW_online] (
	[online_ip] [nvarchar] (15) NULL ,
	[online_date] [nvarchar] (11) NULL ,
	[online_url] [text] NULL ,
	[online_char] [nvarchar] (10) NULL ,
	[online_agent] [text] NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_servers]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_servers]

CREATE TABLE [dbo].[MMW_servers] (
	[name] [nvarchar] (50) NULL ,
	[version] [nvarchar] (50) NULL ,
	[experience] [nvarchar] (50) NULL ,
	[drops] [nvarchar] (50) NULL , 
	[maxplayer] [nvarchar] (50) NULL ,
	[gsport] [nvarchar] (50) NULL ,
	[ip] [nvarchar] (50) NULL ,
	[type] [nvarchar] (50) NULL, 
	[display_order] [nvarchar] (50) NULL 
) ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_votemain]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_votemain]

CREATE TABLE [dbo].[MMW_votemain] (
	[ID] [int] IDENTITY (1, 1) NOT NULL ,
	[question] [nvarchar] (100) NULL ,
	[answer1] [nvarchar] (50) NULL ,
	[answer2] [nvarchar] (50) NULL ,
	[answer3] [nvarchar] (50) NULL ,
	[answer4] [nvarchar] (50) NULL ,
	[answer5] [nvarchar] (50) NULL ,
	[answer6] [nvarchar] (50) NULL ,
	[add_date] [nvarchar] (11) NULL 
) ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_voterow]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_voterow]


CREATE TABLE [dbo].[MMW_voterow] (
	[ID_vote] [int] NULL ,
	[who] [nvarchar] (15) NULL ,
	[answer] [int] NULL 
) ON [PRIMARY]
