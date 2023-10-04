# Custom GPT - Customizable SaaS powered by GPT 3 & 3.5

## What is Custom GPT?

Custom GPT is an AI powered Customizable SaaS assistant Created using [Open AI PHP API](https://github.com/orhanerday/open-ai), [CodeIgniter](https://codeigniter.com/download) [Admin LTE 3](https://adminlte.io/themes/v3/)

This repository has all the necessary AI Toolkits that are required by Digital Marketers and Coders

## How to setup this application on your Localhost environment?

Since this a PHP based SaaS Application you will need Xampp or WampServer on your machine to run it. The database file will be stored inside the <b>Custom GPT Database</b> Folder

<b>Note:</b> Make sure you first setup updated version of [CodeIgniter 4 Framework](https://codeigniter.com/download) and then all the custom files which are explained below.

## The Application structure 

If you want to contribute to this library or create your own GPT based application for your personal work let me guide you through the Application structure of the application so it will be much easier for you to edit the files.

<b>1. Controllers</b>

There are 4 main controllers which are responsible for controlling the entire functionality of this Custom GPT Applications, which are mentioned below:-

- The Home Controller

All the functionality of Login, Forgot Password, Registration is in this controller.
The Registration is coded in such a way that only one person (Admin/Owner) can register. So basically the very first admin registration will be granted the role of Super admin, after that no registrations will be allowed. This is done for Security reasons.

So what if you want your team members want to register their accounts?

Unfortunately for now this code has no functionality for that, If the super admin wants to add the team members to this application the he/she must add team members using the functionality given in the <b>Super admin dashboard</b>.

The super admin dashboard has the functionality to add team members and assign individual user roles.
By default the team members won't have access to Users in other words they won't be able to see registered users, add or delete them.

- The Dashboard Controller

All the functionality related to user profile is inside this controller

For super admin:

Upload/Change Avatar
Change Email
Change Password
Update Name
Add new team member with roles
Block team member (Blocks user from accessingb the account)
Archive team member (Deletes user account temporarily admin can later restore the account it also blocks user from accessing the account)
Deactivate Team Member (Makes account status inactive whicb blocks user from login)
Delete Team member permanently

For Regular users:

Upload/Change Avatar
Change Email
Change Password
Update Name

- The Tools Controller

All the AI tools functionalities and Prompts comes under this controller.

- The History Controller

Funtionality to manage your AI Chat History like Chat GPT comes under this controller.

<b>2. Models</b>

There are only 2 Models which are responsible for managing the database queries controlling the functionalities given inside the above mentioned 4 controllers:-

- The Prompt Model

This model has all the queries to manage the AI Chat History. 
The queries are written using CodeIgniter 4's Query Builder System.

- The Team Model

This Model has all the queries to manage the user dashboard related queries.
The queries are written using CodeIgniter 4's Query Builder System.

<b>3. Helper Functions</b>

In the helper folder of the application you will find <b>form_helper.php</b> that file has function to display validation errors in a clearly for each input field.

<b>4. The views or the pages </b>

The views folder in the applications have all the pages that makes up the entire application. However there are two custom folders that you need to take a look at:-

- Templates Folder

This folder has header and footer files, so all the CSS and Javascript declarations are done inside these files.

- Tools folder

This folder has all the files for the 30 AI Tools, If you want to edit the tool's structure or want to add new tools you will be working mostly with the "Tools folder". All the tools inside this folder is controlled by the <b>Tools controller</b> and the history of these tools is managed by the queries inside the <b>Prompt Model</b>.

The view files outside these two custom folders are all dashboard and user activity related pages and their functionality is controlled by the <b>Home Controller</b> <b>Dashboard Controller</b> and the queries inside the <b>Team Model</b> manages all user activity.

Hence while working with the codebase you will spend most of the time inside the structure explained above.
The rest all depends on your knowledge of CodeIgniter 4 Framework.

## Support my work

If you think that this repository is useful then make sure to support me!

[Click here to Support me on Buy Me a Coffee](https://www.buymeacoffee.com/stackui)