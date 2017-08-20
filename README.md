# MailChimp API v3 component

This example uses the MailChimp API v3 created by <a href="https://github.com/drewm/mailchimp-api" target="_blank">Drew McLellan</a>.

It also includes Google reCAPTCHA to ensure there are no spam subscribes.

I have also added a check that the person agrees to join the mailing list.

## Steps

In order for the example below to work you will need to use your own Google reCAPTCHA site &amp; private keys as well as your MailChimp API key and list ID

1. Go to <a href="https://www.google.com/recaptcha/intro/">https://www.google.com/recaptcha/intro/</a>
2. Click on the Get reCAPTCHA button
3. After logging in, you will need to register your site in order to get your keys.
4. Once you have done this, you can select your site and then click on the Keys section
5. This will give you both your site &amp; private keys
6. In index.html, you can search for SITE_KEY and replace it with your key
7. In submit.php, you can search for PRIVATE_KEY and replace it with your key
8. Next you need to log into your MailChimp account and get your API key and the list you want people to subscribe to.
9. To get your MailChimp API key you can read this <a href="http://kb.mailchimp.com/integrations/api-integrations/about-api-keys" target="_blank">http://kb.mailchimp.com/integrations/api-integrations/about-api-keys</a>
10. To get your MailChimp list ID you can read this <a href="http://kb.mailchimp.com/lists/manage-contacts/find-your-list-id" target="_blank">http://kb.mailchimp.com/lists/manage-contacts/find-your-list-id</a>
11. After you have both your API key and list ID you can replace them in the submit.php by searching for MAILCHIMP_API and LIST_ID
12. Once this has been done, you can upload the files your site and test. Keep in mind you need to upload the files to the same site you added in Google reCAPTCHA
