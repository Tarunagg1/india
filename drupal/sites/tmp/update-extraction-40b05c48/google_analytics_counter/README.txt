Google Analytics Counter is a scalable, lightweight page view counter drawing on data collected by Google Analytics.

Drupal project page is at http://drupal.org/project/issues/google_analytics_counter
Installation, demo and tips are at http://vacilando.org/en/article/google-analytics-counter
If you encounter a problem or need support, see http://drupal.org/project/issues/google_analytics_counter

Author: Tomas Fulopp (Vacilando)
The author can also be contacted at http://vacilando.org/contact for paid customizations of this and other Drupal modules.
Development of this module is sponsored by Vacilando ( http://vacilando.org/ )

CONFIGURATION TO USE OAUTH 2.0
------------------------------
### Creating a Project in Google

1. Go to https://console.developers.google.com/cloud-resource-manager
   Click Create project.

2. Name your project.
   Click Create. Wait several moments for your project to be created.

3. Go to https://console.developers.google.com/apis/dashboard
   You will most likely be directed to your project, or select your project by
   selecting your project's name in the upper left corner of the browser next to
   Google APIS.

4. Click Enable APIS and services on the Google APIs dashboard.
   Search for Analytics API.
   Click Analytics API.
   On the proceeding page, click Enable.

5. You will be sent back to the Google APIs page. Click Credentials in the left-hand column.

6. Click Create credentials. Select OAUTH client ID.

7. Click Configure consent screen.
   Fill out the OAuth consent screen form.
   Click Save.

8. You are sent back to the page where you can select your Application type.
   Select Web application.

9. Name it in the Name field.

10. Leave the Authorized JavaScript origins field blank.

11. Add a url to the Authorized redirect URIs.
    Example: http://localhost/d8/admin/config/system/google-analytics-counter/authentication
    Click Create.

12. Note your client ID and client secret.
    You may also get your client ID and client secret by clicking the pencil icon
    on the right side of the Credentials page next to your application name.

13. Copy your client ID client secret, and Authorized redirect URIs in the google
    analytics authentication form (/admin/config/system/google-analytics-counter/authentication).

See https://youtu.be/119L2DcygyA for a tutorial video by Jasom Dotnet