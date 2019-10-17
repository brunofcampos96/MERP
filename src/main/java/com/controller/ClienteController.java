package com.controller;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RestController;
import com.service.ClientService;
import com.entity.ClientEntity;

@RestController
public class ClientController extends AbstractController {
    
    @Autowired
    public void setController(ClientService service) {
        this.service = service;
    }
    
    @GetMapping("/clientes")
    private List<ClienteEntity> getAll() {
        super.getAll();
    }

    @GetMapping("/clientes/{id}")
    private ClienteEntity get(@PathVariable("id") Long id) {
        return super.getById(id);
    }

    @DeleteMapping("/clientes/{id}")
    private void delete(@PathVariable("id") Long id) {
        super.save(id);
    }

    @PostMapping("/clientes")
    private Long save(@RequestBody Entity client) {
        return super.save(client);
    }
}