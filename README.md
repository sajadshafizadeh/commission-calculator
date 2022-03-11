## Installation & Getting started steps:

1. Download the project
2. Run command `composer install` in the root
3. Run command  `php bin/console CommissionCalculator --input_file_path=C:\xampp\htdocs\commission_calculator\input.txt`

**Note1:** Replace the value of `--input_file_path` option with the real input (transactions) file on your computer.

**Note2:** Since the excahge list API has a tough limitation reach, I put its content inside a file and use that file while developing. You can simple comment the current `EXCHANGE_RATES_FILE` (located inside `src\Command\CommissionCalculatorCommand.php`) and uncomment the upper line to use the API again for calculation.

----

### Notes

- It took about 30 mins to make your code working. since one of your used APIs needs a access token that wasn't exist in your code. The whole development took about 5 hours:
    * Reviewing/understanding the code (~40 Mins)
    * Making the code working (~30 Mins)
    * Raw project init (~20 Mins)
    * Architecture designing in high-level (~40 Min)
    * Codding (1 Hour)
    * Debugging (20 Min)
    * Writing Tests (30 Min)
    * Code improvement (1 Hour)
    * **In total: ~5 Hours** 

- In my opinion, there was no need to use any framework for this task (It could be done just by using a couple of packages/components), but because you mentioned it's better to use Symfony framework, I used the full version of it. Noted that I am not a Symfony expert, the framework I have a lot of experience with is Laravel.

- Since there is no HTTP(s) request, I've not used Controller. I used Command instead.

- If the project is multilanguage, in that case, there is a need to define a file to define messages in different languages. I assumed the project would be just in English.

- Since I have been the only developer on this repo, I didn't care about branching.

- Docker can be simply added to the project .. if it's needed, let me know.

- Caching exchange rates, reading base URLs from a config file, putting commission calculation formula in a different file and etc .. are good-to-have things that looked beyond the scope of the exercise to me.

- I did it at different times/places. Partially at home, partially in the library, and even partially at the bus :P . So, excuse me if you see something ugly in it. I could not concentrate much this week.

