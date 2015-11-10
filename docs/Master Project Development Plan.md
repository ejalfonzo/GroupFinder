
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
  - Able to create an account and log into the site. (Core)
  - Able to reset their password. (Core)
  - Able to edit their profile. (Core)
  - Able to delete their account from the system. (Core)
  - Able to post to their timeline. (Core)
  - Able to search for a user, group or business by name or category. (Core)
  - Able to add a user they know as a friend. (Core)
  - Able to remove a friend from their friend's list. (Core)
  - Able to define categories and set friends into them. (Core)
  - Able to create a group. (Core)
  - Able to edit a group's information. (Core)
  - Able to delete a group. (Core)
  - Able to create an event. (Core)
  - Able to edit an event's information. (Core)
  - Able to delete an event. (Core)
  - Able to invite friends to an event. (Desired)
  - Able to invite followers to an event (business). (Desired)
  - Able to invite a group to an event. (Desired)
  - Able to create a business profile. (Core)
  - Able to edit a business profile. (Core)
  - Able to delete a business profile. (Core)
  - Able to join a group. (Core)
  - Able to leave a group. (Core)
  - Able to invite friends to join a group. (Desired)
  - Able to post to a group's timeline (if they are a member of this group). (Core)
  - Able to join an event. (Core)
  - Able to leave an event. (Core)
  - Able to read an event's timeline (if they have joined this event). (Core)
  - Able to follow a business' profile. (Core)
  - Able to un-follow a business' profile. (Core)
  - Able to accept or deny friends requests.  (Desired)
  - Able to accept or deny users joining a group. (Optional)
  - Able to acceopt or deny users joining an event.  (Optional)
  - Able to email everyone who has joined an event. (Optional)
  - Able to email all followers of an business. (Optional)
  - Able to email all friends. (Optional)
  - Able to specify a location for an event or business using google maps or similar technology. (Optional)
  - Able to add events to google calendar or similar technology. (Optional)
  - Able to see events that user has joined in a calendar plugin. (Desired)
  - Recieves events or groups of similar interests as suggestions. (Optional)
  - Able to edit a post they have created. (Desired)
  - Able to reply to posts.  (Desired)

- System Requirements (The following are things the app will do on its own either automatically or via prompts from the user depending on the specific case): 
  - Will send email notifications to reset a user's password. (Core)
  - Will send periodical emails (daily, weekly, monthly...etc.) to users to let them know of posts to their timeline, posts by businesses they follow, and events happening in the near future. (Core)
  - Will send immediate emails to notify users of posts to their timeline of events happening in the very near future. (Desired)
  - Will allow users to opt out of recieving immediate emails. (Desired)
  - Will filter out mispelled or unused categories, and replace them with the proper or closest matches. (Optional)


The Project will be split into protoype phases that will coincide with the Sprints mentioned in the ICOM5016F15-ClassProject1 documenation, as such they will be named the same. (Phase 1 = Sprint 1, Phase 2 = Sprint 2... etc.) Each phase completion will also be a milestone, but in addition, completing sets of related requirements will also accomplish a milestone. As such the following are a list of high-level milestones for this project:

1. Phase 1
  1. ~~Base Site running ~~
  2. ~~Working DBMS running ~~
  3. ~~Mockups on site ~~
  4. ~~Home Page Search Prototype ~~
  5. ~~User Basic functionality ~~
2. Phase 2
  1. ~~User page ~~
  2. ~~Groups Basic functionality ~~
3. Phase 3
  1. ~~ Events Basic functionality ~~
  2. ~~ Business Basic functionality ~~
  3. ~~ Search Results functionality ~~
4. Phase 4
  1. ~~ Friends functionality ~~
  2. ~~ Business functionality ~~
  3. ~~ Events functionality ~~
  4. ~~ Groups functionality ~~
5. Phase 5
  1. Automated Tests: Business
  2. Project Complete
  3. Email functionality
  4. Post functionality
  5. Automated Tests: Post, Friends
  6. Automated Tests: Events, Email
  7. Chat


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

3. Phase 3: Friends and Groups

Due to some time management issues phase 3 will focus on picking up unfinished parts of phase 2, and continue with completing parts of groups, and events. While some of these features seem like adding to the work load, work on them was already begun in phase 2, they simply need to be finished.

Specific functions we will achieve will include:
- Searching for users, groups, businesses, and events by name or category respectively
- Adding users to a friends list
- Adding a category to a friend
- Editing a friend's category
- Removing a friend from the friend's list
- Joining a group
- Creating an Event
- Joining and Event

4. Phase 4: Business, Posts and Email

This phase, like phase 3 will focus on catchup work from other phases followed by funcionality of posts to the user timeline, groups and businesses. Editing and Deleting Events, Groups, and Businesses. And Email basic functionality for certain action like posting.

Specific functions we well achieve will include:
- Adding users to a friends list
- Adding a category to a friend
- Editing a friend's category
- Removing a friend from the friend's list
- Editing a group
- Editing an Event
- Editing a Business

5. Phase 5: Clean-up and Finishing

This phase will focus on cleaning up any leftover requirements from previous phases and finishing up the project. Particularly the functionality of Emails and Posts will be priority.

- Posting to timeline
- Posting to Group
- Posting to Business
- Email sending when a post is made.
