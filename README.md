# Alkamara-Center
Magento 2 site version magento2.4

### magento Requirements
- php version 7.4
- elastic search must be installed on server.

### Deploy Code from GitHub Repository

### Admin
Create admin user using below command
- php bin/magento admin:user:create
- You can find admin url in app/etc/env.php file that is "admin_13q4a5"
### Database file
- named with "KandC.sql"
- change url in "core_config_data" table

### Commands 
Run following below commands to delpoy code
- php bin/magento setup:upgrade
- php bin/magento setup:di:compile
- php bin/magento setup:static-content:deploy -f
- php bin/magento indexer:reindex
- php bin/magento cache:flush

### Reporting Security Issues
To report security vulnerabilities or learn more about reporting security issues in Magento software or web sites visit the Magento Bug Bounty Program on hackerone. Please create a hackerone account there to submit and follow-up on your issue.

Stay up-to-date on the latest security news and patches for Magento by signing up for Security Alert Notifications.

### Community Engineering Slack
To connect with Magento and the Community, join us on the Magento Community Engineering Slack. If you are interested in joining Slack, or a specific channel, send us a request at engcom@adobe.com or self signup.

We have channels for each project. These channels are recommended for new members:

general: Open chat for introductions and Magento 2 questions
github: Support for GitHub issues, pull requests, and processes
public-backlog: Discussions of the Magento 2 backlog
