<b>A message from the creator</b>
<br>
Thank you for visiting the @kaustubhdevstack/customgpt repository! If you find this repository helpful or useful, we encourage you to start it on GitHub. Starring a repository is a way to show your support for the project. It also helps to increase the visibility of the project and to let the community know that it is valuable. Thanks again for your support and we hope you find the repository useful!

# Custom GPT - AI Assistant toolkit 

Watch Video https://www.youtube.com/watch?v=AozAlTwaQdY&t=3s

## What is Custom GPT?

Custom GPT is an AI-powered Customizable SaaS assistant Created using [Open AI PHP API Library](https://github.com/orhanerday/open-ai), [CodeIgniter](https://codeigniter.com/download) [Admin LTE 3](https://adminlte.io/themes/v3/)

This repository has all the necessary AI Toolkits that are required by Digital Marketers and Coders

## List of tools that are included in the Custom GPT

01. Creative Title Maker
02. E-commerce Title Maker
03. Topic Suggestions
04. Youtube Suggestions
05. Short Video Suggest
06. Create Content Outline
07. Description Maker
08. Meta Description Maker
09. Improve/Fix Content
10. Email Writer
11. Keyword Extractor
12. Linkedin Profile Bio Maker
13. Social Media Page Bio Maker
14. Tweet Maker
15. Instagram Captions Maker
16. Create Viral Hashtags
17. Review Generator
18. Strategy Maker
19. Meme Maker
20. Google Ads
21. Meta Ads
22. Linkedin Ads
23. Code Writer
24. Regular Expressions Generator
25. Code Reviewer
26. Bug Fixer
27. Improve Code
28. Secure Code
29. Convert Code
30. Generate SQL/MySQL

## How to set up this application on your Localhost environment?

Since this is a PHP-based SaaS Application you will need Xampp or WampServer on your machine to run it. The database file will be stored inside the <b>Custom GPT Database</b> Folder

<b>Note:</b> Make sure you first set up an updated version of [CodeIgniter 4 Framework](https://codeigniter.com/download) and then all the custom files which are explained below.

## The Application structure 

If you want to contribute to this library or create your own GPT-based application for your personal work let me guide you through the Application structure of the application so it will be much easier for you to edit the files.

<b>1. Controllers</b>

There are 4 main controllers which are responsible for controlling the entire functionality of this Custom GPT Applications, which are mentioned below:-

- <b>The Home Controller</b>

All the functionality of Login, Forgot Password, and Registration is in this controller.
The Registration is coded in such a way that only one person (Admin/Owner) can register. So basically the very first admin registration will be granted the role of Super admin, after that no registrations will be allowed. This is done for Security reasons.

So what if you want your team members to want to register their accounts?

Unfortunately for now this code has no functionality for that, If the super admin wants to add the team members to this application he/she must add team members using the functionality given in the <b>Super admin dashboard</b>.

The super admin dashboard has the functionality to add team members and assign individual user roles.
By default the team members won't have access to Users in other words they won't be able to see registered users, or add or delete them.

- <b>The Dashboard Controller</b>

All the functionality related to the user profile is inside this controller

<b>For super admin:</b>

- Upload/Change Avatar
- Change Email
- Change Password
- Update Name
- Add new team members with roles
- Block team member (Blocks user from accessing the account)
- Archive team member (Deletes user account temporarily admin can later restore the account it also blocks the user from accessing the account)
- Deactivate Team Member (Makes account status inactive which blocks the user from login)
- Delete Team member permanently

<b>For Regular users:</b>

- Upload/Change Avatar
- Change Email
- Change Password
- Update Name

- <b>The Tools Controller</b>

All the AI tool's functionalities and Prompts come under this controller.

- <b>The History Controller</b>

The functionality to manage your AI Chat History like Chat GPT comes under this controller.

<b>2. Models</b>

There are only 2 Models that are responsible for managing the database queries controlling the functionalities given inside the above-mentioned 4 controllers:-

- <b>The Prompt Model</b>

This model has all the queries to manage the AI Chat History. 
The queries are written using CodeIgniter 4's Query Builder System.

- <b>The Team Model</b>

This Model has all the queries to manage the user dashboard-related queries.
The queries are written using CodeIgniter 4's Query Builder System.

<b>3. Helper Functions</b>

In the helper folder of the application, you will find <b>form_helper.php</b> that file has a function to display validation errors clearly for each input field.

<b>4. The views or the pages </b>

The views folder in the applications has all the pages that make up the entire application. However, there are two custom folders that you need to take a look at:-

- <b>Templates Folder</b>

This folder has header and footer files, so all the CSS and Javascript declarations are done inside these files.

- <b>Tools folder</b>

This folder has all the files for the 30 AI Tools, If you want to edit the tool's structure or want to add new tools you will be working mostly with the "Tools folder". All the tools inside this folder are controlled by the <b>Tools controller</b> and the history of these tools is managed by the queries inside the <b>Prompt Model</b>.

The view files outside these two custom folders are all dashboard and user activity-related pages and their functionality is controlled by the <b>Home Controller</b> <b>Dashboard Controller</b> and the queries inside the <b>Team Model</b> manages all user activity.

Hence while working with the codebase you will spend most of the time inside the structure explained above.
The rest all depends on your knowledge of the CodeIgniter 4 Framework.

## The .ENV File

We have used Open AI for this to make sure the AI tools function properly, hence, these tools won't work without an Open AI API Key, so make sure you add the API Key before working with the application itself. 

OPEN_AI_API_KEY = '' 

## Open AI PHP Library

This application uses [Open AI PHP API Library](https://github.com/orhanerday/open-ai) Created by [Orhanerday](https://github.com/orhanerday)
The files can be found at - vendor/orhanerday/open-ai

## Support my work

If you think that this repository is useful then make sure to support me!

[Click here to Support me on Buy Me a Coffee](https://www.buymeacoffee.com/stackui)
