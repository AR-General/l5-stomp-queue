<?php 

namespace Mayconbordin\L5StompQueue\Broadcasters;

use Stomp\StatefulStomp as Stomp;
use Illuminate\Contracts\Broadcasting\Broadcaster;
use Illuminate\Support\Arr;

class StompBroadcaster implements Broadcaster
{
    /**
     * The Stomp instance.
     *
     * @var Stomp
     */
    protected $stomp;

    /**
     * The Stomp credentials for connection.
     *
     * @var array
     */
    protected $credentials;

    /**
     * Create a Stomp Broadcaster.
     *
     * @param Stomp $stomp
     * @param array $credentials [username=string, password=string]
     */
    public function __construct(Stomp $stomp, array $credentials = [])
    {
//        dump("__construct");
        $this->stomp = $stomp;
        $this->credentials = $credentials;
//        dump($stomp);
//        dump($credentials);
//        dump($this);
//        dump($this->stomp->getClient()->isConnected());
        
    }

    /**
     * Broadcast the given event.
     *
     * @param  array $channels
     * @param  string $event
     * @param  array $payload
     * @return void
     */
    public function broadcast(array $channels, $event, array $payload = [])
    {
//        dump('this->connect(), this->', $this);

        $this->connect();
//        dump('this->connect() 1, this->', $this, "1");

        $payload = json_encode(['event' => $event, 'data' => $payload]);

        foreach ($channels as $channel) {
            $this->stomp->getClient()->send($channel, $payload);
//            $this->stomp->send($channel, $payload);
        }
    }

    /**
     * Connect to Stomp server, if not connected.
     *
     * @throws \FuseSource\Stomp\Exception\StompException
     */
    protected function connect()
    {
//        if (!$this->stomp->isConnected()) {
//            $this->stomp->connect(Arr::get($this->credentials, 'username', ''), Arr::get($this->credentials, 'password', ''));
//        }
//        dump("connect()", $this->credentials, Arr::get($this->credentials, 'username', 'AA1'));
        if (!$this->stomp->getClient()->isConnected()) {
            $this->stomp->getClient()->connect(Arr::get($this->credentials, 'username', 'AA1'), Arr::get($this->credentials, 'password', 'P22'));
        }
    }

    public function auth($request) {
        dump($request);
        return true;
    }

    public function validAuthenticationResponse($request, $result) {
        dump($request);
        dump($result);
        return true;
    }

}
