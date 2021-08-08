
## Getting Started

Basic idea is to generate an oriented graph from the tickets location and destinations and add arcs based on the direction. After that, we use a depth first search algorithm to find the terminal node and determine the fastest route there. In case there are more terminal nodes, the program will throw an error.

Note that even if there are no different classes for different ticket types, te time was mostly spent on trying to optimise the algorithm and suggesting an optimal route. Also, there were performed only manual tests.

There were more assumptions made here:
<ul>
  <li>Kevin's family will have the same tickets as Kevin</li>
  <li>Kevin's family WILL use ALL of the tickets, but Kevin doesn't have to</li>
  <li>There is no problem if Kevin reaches a location before his family, it is actually preffered this way, since they have a head start, he will wait for them there (since there is no travel time added on the tickets, he will wait for them at the final location.)</li>
  <li>There might be locations with multiple tickets. In case that is not the end  of the journey, we need to ensure there is an alternate route to go back from there, otherwise kevin will be in a situation where he will need to choose the final location from multiple choices that could be suitable for this role.
    <img style="height: 200px" src="https://static.javatpoint.com/ds/images/binary-tree.png"> </br>
      Take the above case for example, if the would be the generated route using the tickets, kevin will don't know if the ending location should be the 3,5 or 6 node, hence an error will be thrown.
  </li>
</ul>

### Prerequisites

You can either install it :
* with composer
  ```sh
  composer require test/route-generator
  ```
* or clone this repo and run the following command in the root directory of the project
  ```sh
  composer dump-autoload 
  ```

<!-- USAGE EXAMPLES -->
## Usage

 ```sh
use Test\RouteGenerator\RouteGenerator;
use Test\RouteGenerator\Ticket;
use Test\RouteGenerator\TicketType;


  $routerGenerator = new RouteGenerator([
    new Ticket('Germany', 'Italy', TicketType::Boat, 'RJ 45', 'Seat 32'),
    new Ticket('Germany', 'France', TicketType::Bus, '336'),
    new Ticket('Italy', 'Spain', TicketType::Airplane, 'ITSP 453'),
    new Ticket('Spain', 'Austria', TicketType::Bus, '', 'No seats'),
    new Ticket('France', 'Portugal', TicketType::Boat),
    new Ticket('Portugal', 'France', TicketType::Airplane),
    new Ticket('France', 'Bulgaria', TicketType::Boat),
    new Ticket('Bulgaria', 'France', TicketType::Bus),
    new Ticket('France', 'Romania', TicketType::Airplane),
    new Ticket('Romania', 'Greece', TicketType::Train),
    new Ticket('Greece', 'Germany', TicketType::Bus),
], 'Germany');


foreach($routerGenerator->getRoute() as $ticket){
    echo $ticket;
}
  ```

## Possible improvements

Some possible improvements for this could be, when the algorithm gets confused, instead of throwing an error, give Kevin the option to manually choose the next step.

Adding the travel time on the ticket, that way it would be much more accurate to approximate the meeting spot.
