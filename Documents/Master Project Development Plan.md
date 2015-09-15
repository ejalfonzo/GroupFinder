
Project Overview

GroupFinder site will be built in several Phases, each containing a working prototype of the final app(website) with increased functionality. Initially the app will be a working model of a simple social networking site, it will progress in complexity and scope until all functional requirements are met, and should there be time we will work on added functionality.

Functional Requirements

The following requirements are split between these categories:
- Core (Mandatory) Requirements: Which will be necessary to complete the project and provide the base experience for the user.
- Desired Requirements: Which will be accomplished should there be time, and will enhance the base experience.
- Optional Requirements: Which will be attempted if the team is ahead of schedule or finds them easy to complete offhandedly.

Notes: Any requirements that relate to a non-admin user managing a group, business or event (editing or deleting), assumes that this user is the manager(creator) of this entity.

Requirements:
- User Requirements (The following are things the user can do with or in the app):
  - Able to create an account and log into the site.
  - Able to reset their password.
  - Able to edit their profile.
  - Able to delete their account from the system.
  - Able to post to their timeline.
  - Able to search for a user, group or business by name or category.
  - Able to add a user they know as a friend.
  - Able to remove a friend from their friend's list.
  - Able to define categories and set friends into them.
  - Able to create a group.
  - Able to edit a group's information.
  - Able to delete a group.
  - Able to create an event.
  - Able to edit an event's information.
  - Able to delete an event.
  - Able to invite friends, groups or followers(business) to an event.
  - Able to create a business profile.
  - Able to edit a business profile.
  - Able to delete a business profile.
  - Able to join a group.
  - Able to leave a group.
  - Able to post to a group's timeline (if they are a member of this group).
  - Able to join an event.
  - Able to leave an event.
  - Able to read an event's timeline (if they have joined this event).
  - Able to follow a business' profile.
  - Able to un-follow a business' profile.

- System Requirements (The following are things the app will do on its own either automatically or via prompts from the user depending on the specific case): 
  - Will send email notifications to reset a user's password.
  - Will send periodical emails (daily, weekly, monthly...etc.) to users to let them know of posts to their timeline, posts by businesses they follow, and events happening in the near future.
  - Will send immediate emails to notify users of posts to their timeline of events happening in the very near future.
  - Will allow users to opt out of recieving immediate emails.


The Project will be split into protoype phases that will coincide with the Sprints mentioned in the ICOM5016F15-ClassProject1 documenation, as such they will be named the same. (Phase 1 = Sprint 1, Phase 2 = Sprint 2... etc.) Each phase completion will also be a milestone, but in addition, completing sets of related requirements will also accomplish a milestone. As such the following are a list of high-level milestones for this project:

1. Phase 1
  1. Base Site running
  2. Working DBMS running
  3. Mockups on site
  4. Home Page Search Protype
  5. User Basic functionality
2. Phase 2
  1. User page
  2. Post functionality
  3. Friends
  4. Groups Basic functionality
3. Phase 3
  1. Groups finished
  2. Events
  3. Business Basic functionality
  4. Automated Tests: Post, Friends
4. Phase 4
  1. Business finished
  2. Automated Tests: Events, Email
5. Phase 5
  1. Automated Tests: Business
  2. Project Complete


Detailed Plans

1. Phase 1: App GUI and DBMS

General plan for this phase includes a mock-site, or rough prototype fully hosted, meaning a working website with access to all the planned views, though not all these views will be working, functionality will be added in later prototypes as the project progresses.

In this case when refering to 'page' we talk about where you can see someone's timeline/profile.

The necessary views will be:
- Landing Page (home or index page)
- Search results
- User login (logged out)
- User page
- User profile editing
- Group creation
- Group editing (might be the same as creation)
- Group page
- Event creation
- Event editing (might be the same as creation)
- Event page
- Business creation
- Business editing (might be the same as creation)
- Business page
- About page
- Contact page

The DBMS will be mySQL, as such all the tables will need to be created, along with some basic queries like:
- CRUD User (create, read, update, delete)
- Basic Search Query to find users, groups, businesses and events (though some may not exist other than created manually, for now)

2. Phase 2: The User

The emphasis of phase 2 will be user functionality. With that in mind we will work on completing the user page which will include the user's timeline, ability to post, ability to add friends and create groups. With this there will likely be work on the email system to send an email when a friend posts, opting out of immediate emails. We will also work on sorting friends by creating categories.

The specific functions we will achieve will include:
- Account creation
- Login
- Reset password
- Logout
- Account deletion
- Editing their profile
- Searching for users, groups, businesses, and events by name or category respectively
- Adding users to a friends list
- Adding a category to a friend
- Editing a friend's category
- Removing a friend from the friend's list
- Posting to own timeline
- Creating a group
- Joining a group

The following will be worked on ahead if time allows, otherwise they will be addressed in Phase 3:
- Editing a group
- Posting to a group's timeline
- Deleting a group

