if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_chatbox]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_chatbox]

CREATE TABLE [dbo].[MMW_chatbox] (
	[f_id] [int] IDENTITY (1, 1) NOT NULL,
	[f_char] [varchar] (10) NOT NULL,
	[f_message] [text] NULL,
	[f_date] [int] NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_comment]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_comment]

CREATE TABLE [dbo].[MMW_comment] (
	[c_id] [int] IDENTITY (1, 1) NOT NULL,
	[c_id_blog] [varchar] (50) NULL,
	[c_id_code] [varchar] (50) NULL,
	[c_char] [varchar] (10) NULL,
	[c_text] [text] NULL,
	[c_date] [int] NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_forum]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_forum]

CREATE TABLE [dbo].[MMW_forum] (
	[f_id] [varchar] (50) NULL,
	[f_char] [varchar] (10) NULL,
	[f_catalog] [int] NULL,
	[f_title] [varchar] (50) NULL,
	[f_text] [text] NULL,
	[f_created] [int] NULL,
	[f_date] [int] NULL,
	[f_lastchar] [varchar] (10) NULL,
	[f_status] [int] NULL,
	[f_comments] [int] NULL,
	[f_views] [int] NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_links]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_links]

CREATE TABLE [dbo].[MMW_links] (
	[l_name] [varchar] (100) NULL,
	[l_address] [text] NULL,
	[l_description] [text] NULL,
	[l_size] [varchar] (100) NULL,
	[l_id] [varchar] (100) NULL,
	[l_date] [int] NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_market]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_market]

CREATE TABLE [dbo].[MMW_market] (
	[item_id] [int] IDENTITY (1, 1) NOT NULL,
	[item_char] [varchar] (50) NULL,
	[item_category] [int] NULL,
	[item_group] [int] NULL,
	[item_style] [int] NULL,
	[item_zen] [bigint] NULL,
	[item_coin] [bigint] NULL,
	[item_hex] [varchar] (50) NULL,
	[item_date] [int] NULL 
) ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_news]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_news]

CREATE TABLE [dbo].[MMW_news] (
	[news_id] [varchar] (100) NULL,
	[news_title] [varchar] (100) NULL,
	[news_category] [varchar] (100) NULL,
	[news_row_1] [text] NULL,
	[news_row_2] [text] NULL,
	[news_row_3] [text] NULL,
	[news_autor] [varchar] (10) NULL,
	[news_date] [int] NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_online]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_online]

CREATE TABLE [dbo].[MMW_online] (
	[online_ip] [varchar] (50) NULL,
	[online_date] [int] NULL,
	[online_url] [text] NULL,
	[online_char] [varchar] (50) NULL,
	[online_agent] [text] NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_servers]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_servers]

CREATE TABLE [dbo].[MMW_servers] (
	[name] [varchar] (50) NULL,
	[version] [varchar] (10) NULL,
	[experience] [varchar] (10) NULL,
	[drops] [varchar] (10) NULL,
	[maxplayer] [int] NULL,
	[gsport] [int] NULL,
	[ip] [varchar] (15) NULL,
	[type] [varchar] (10) NULL,
	[display_order] [int] NULL 
) ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_votemain]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_votemain]

CREATE TABLE [dbo].[MMW_votemain] (
	[ID] [int] IDENTITY (1, 1) NOT NULL,
	[question] [varchar] (100) NULL,
	[answer1] [varchar] (50) NULL,
	[answer2] [varchar] (50) NULL,
	[answer3] [varchar] (50) NULL,
	[answer4] [varchar] (50) NULL,
	[answer5] [varchar] (50) NULL,
	[answer6] [varchar] (50) NULL,
	[add_date] [int] NULL 
) ON [PRIMARY]



if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[MMW_voterow]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[MMW_voterow]

CREATE TABLE [dbo].[MMW_voterow] (
	[ID_vote] [int] NULL,
	[who] [varchar] (15) NULL,
	[answer] [int] NULL 
) ON [PRIMARY]