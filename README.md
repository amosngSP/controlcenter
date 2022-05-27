## Control Center
Training Management System originally created by [Daniel L.](https://github.com/blt950) (1352906), [Gustav K.](https://github.com/gustavkauman) (1262761) and others from Web Department at VATSIM Scandinavia. Running using `Laravel 9`, based on `SB Admin 2` boostrap theme.

The project is open source and contains some restirctions. Read the [LICENSE.md](LICENSE.md) for details.

**Remember to watch this repository to get notified of our patches and updates!*

![2022-05-22 12_42_15-Dashboard _ Control Center and 11 more pages - Personal - Microsoft​ Edge](https://user-images.githubusercontent.com/2505044/169692486-50ca8cb6-54a4-41a7-a18d-13a329234d30.png)


## Prerequisites
- An environment that can host PHP websites, such as Apache, Ngnix or similar.
- [Laravel 9 Requirements](https://laravel.com/docs/9.x/deployment#server-requirements)
- Using [Handover](https://github.com/Vatsim-Scandinavia/handover) as user data source

## Setup and install
Just clone this repository and you're almost ready. First, make sure you've installed [Composer](https://getcomposer.org) and [Node.js](https://nodejs.org/en/) in your environment.

1. Upload your logo and optionally a email specific logo to `/public/images/logos/`
2. Run `./deploy init <container name>` to setup the required files, if you're not using container run the deploy.sh located in `.docker` folder instead.
3. Copy and configure the .env file accordingly, including logos and simple theming.
4. Run `npm run dev` in development environment or `npm run dev` in production to build front-end assets
5. Run `php artisan serve` to host the page at `localhost:8000` in development environment.

## Configuring
To have Control Center reflect your division correctly, you need to do some tweaks.
- Once you've made your user admin by manipulating the database, you can access `Administration -> Settings` in menu to tweak the most basic settings for your division.
- [Setup Cron in your environment](https://laravel.com/docs/9.x/scheduling#running-the-scheduler)
- You are also required to configure logic and datasets in the MySQL database as described in [CONFIGURE.md](CONFIGURE.md) with examples

## Deployment

To deploy in development environment use `./deploy dev <container name>`, in production use `./deploy prod <container name>`. This will automatically put the site in maintenance mode while it's deploying and open back up when finished.

## Using the API
There's an Control Center API that you can use to
- GET, POST, PATCH and DELETE bookings `/api/bookings` and more
- GET users assigned roles and their area `/api/roles`
- GET users holding Major Airport / Special Center endorsements `/api/endorsements/masc`
- GET users holding Training endorsements `/api/endorsements/training/solo` & `/api/endorsements/training/s1`
- GET users holding Examiner endorsements `/api/endorsements/examiner`
- GET users holding Visiting endorsements `/api/endorsements/visiting`

To create an API key use `php artisan create:apikey`, use the returned token as authentication bearer.

## Present automations
There's quite a few automations in Control Center that are running through the cron-jobs. They're as follows:
- All trainings with status In Queue or Pre-Training are given a continued interest request each month, and a reminder after a week. Failing to reply within two weeks closes the request automatically.
- ATC Active is flag given based on ATC activity. Refreshes daily with data from VATSIM Data API. It counts the hours from today's date and backwards according to the length of qualification period.
- Daily member cleanup, if a member leaves the division, their training will be automatically closed. Same for mentors. Does not apply to visitors.
- Other misc cleanups

## Contribution, conventions and intro to Laravel
Read the [CONTRIBUTE.md](CONTRIBUTE.md) for details.
