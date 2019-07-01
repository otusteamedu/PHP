<?php
declare(strict_types=1);

use lexerom\Email\Rule\RuleInterface;
use lexerom\Email\Validator as EmailValidator;
use lexerom\Email\Rule\{Dns, DomainName, LocalPart};
use PHPUnit\Framework\TestCase;

class EmailValidatorTest extends TestCase
{
    const LOCAL_VALID = 'example123-gfff+me';
    const LOCAL_INVALID = 'exampl$ #';
    const DOMAIN_VALID = 'example44.xmpl.weweee.fffff.us';
    const DOMAIN_INVALID = 'example_-?.com';
    const DOMAIN_DNS_VALID = 'gmail.com';
    const DOMAIN_DNS_INVALID = 'gmailsassdd.com';

    /**
     * @var EmailValidator
     */
    private $validator;

    public function setUp(): void
    {
        $this->validator = new EmailValidator();
    }

    public function testLocalPart(): void
    {
        $this->validator->addRule(new LocalPart());

        $this->assertTrue($this->validator->validate(self::LOCAL_VALID . '@' . self::DOMAIN_DNS_VALID));
        $this->assertTrue($this->validator->validate(self::LOCAL_VALID . '@' . self::DOMAIN_INVALID));
        $this->assertFalse($this->validator->validate(self::LOCAL_INVALID . '@' . self::DOMAIN_DNS_VALID));
        $this->assertFalse($this->validator->validate(self::LOCAL_INVALID . '@' . self::DOMAIN_INVALID));
    }

    public function testDomain(): void
    {
        $this->validator->addRule(new DomainName());

        $this->assertTrue($this->validator->validate(self::LOCAL_VALID . '@' . self::DOMAIN_VALID));
        $this->assertTrue($this->validator->validate(self::LOCAL_INVALID . '@' . self::DOMAIN_VALID));


        $longDomain = 'qewqwegfffdddddddjrkrjreriojterjtreito.' .
            'rtretttjg8ourlkt43jjhergljfhghslhgfjkhdfdgdguuuuuuiiiiqweqweqweqweqweqweqweqweqweetgggggwrt' .
            'retttjg8ourlkt43jjhergljfhghslhgfjkhdfdgdguuuuuuiiiiqweqweqweqweqweqweqweqweqweetgggggwrtre' .
            'tttjg8ourlkt43jjhergljfhghslhgfjkhdfdgdguuuuuuiiiiqweqweqweqweqweqweqweqweqweetgggggwrtrett' .
            'tjg8ourlkt43jjhergljfhghslhgfjkhdfdgdguuuuuuiiiiqweqweqweqweqweqweqweqweqweetgggggw.com';
        $invalidDomainLength = strlen($longDomain);
        $this->assertFalse($this->validator->validate(
            self::LOCAL_VALID . '@' . $longDomain),
            'Domain length assertion. Length: ' . $invalidDomainLength);
        $this->assertFalse($this->validator->validate(self::LOCAL_VALID . '@' . self::DOMAIN_INVALID));
        $this->assertFalse($this->validator->validate(self::LOCAL_INVALID . '@' . self::DOMAIN_INVALID));
    }

    public function testDns(): void
    {
        $this->validator->addRule(new Dns());

        $this->assertTrue($this->validator->validate(self::LOCAL_VALID . '@' . self::DOMAIN_DNS_VALID));
        $this->assertTrue($this->validator->validate(self::LOCAL_INVALID . '@' . self::DOMAIN_DNS_VALID));
        $this->assertFalse($this->validator->validate(self::LOCAL_VALID . '@' . self::DOMAIN_DNS_INVALID));
        $this->assertFalse($this->validator->validate(self::LOCAL_INVALID . '@' . self::DOMAIN_DNS_INVALID));
    }

    public function testEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new EmailValidator())->validate(123);
    }

    public function testValidator(): void
    {
        $this->validator->addRule(new Dns())
            ->addRule(new DomainName())
            ->addRule(new LocalPart());

        $rules = $this->validator->getRules();

        $this->assertCount(3, $rules);

        //check priority
        $lowestPriority = 0;
        foreach($rules as $rule) {
            /**
             * @var RuleInterface $rule
             */
            $priority = $rule->getPriority();

            $this->assertGreaterThanOrEqual($lowestPriority, $priority);
            $lowestPriority = $priority;
        }

        $this->assertTrue($this->validator->validate(self::LOCAL_VALID . '@' . self::DOMAIN_DNS_VALID));

        $this->assertFalse($this->validator->validate(self::LOCAL_VALID . '@' . self::DOMAIN_DNS_INVALID));
        $this->assertFalse($this->validator->validate(self::LOCAL_VALID . '@' . self::DOMAIN_VALID));
        $this->assertFalse($this->validator->validate(self::LOCAL_INVALID . '@' . self::DOMAIN_DNS_VALID));
    }
}
