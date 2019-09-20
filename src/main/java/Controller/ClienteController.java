package Controller;

import java.util.concurrent.atomic.AtomicLong;

import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.bind.annotation.RestController;
import Service.ClienteService;

@RestController
public class ClienteController {

    private final AtomicLong counter = new AtomicLong();
    
    @RequestMapping("/insere")
    public @ResponseBody ClienteService insere(){
        return new ClienteService(counter.incrementAndGet(), "Bruno", "13034259638", "bruno.campos@sk.com.br");
    }

    @RequestMapping("/recupera")
    public @ResponseBody ClienteService recupera(){
        return new ClienteService(counter.incrementAndGet(), "Bruno", "13034259638", "bruno.campos@sk.com.br");
    }

}
