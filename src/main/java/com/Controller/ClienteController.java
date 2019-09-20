package com.Controller;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RestController;
import com.Service.ClienteService;
import com.Entity.ClienteEntity;

@RestController
public class ClienteController {

    @Autowired
    ClienteService clienteService;
    
    @GetMapping("/clientes")
    private List<ClienteEntity> getAllClientes() {
        return clienteService.getAllClientes();
    }

    @GetMapping("/clientes/{id}")
    private ClienteEntity getCliente(@PathVariable("id") Long id) {
        return clienteService.getClienteById(id);
    }

    @DeleteMapping("/clientes/{id}")
    private void deleteCliente(@PathVariable("id") Long id) {
        clienteService.delete(id);
    }

    @PostMapping("/clientes")
    private Long savePerson(@RequestBody ClienteEntity cliente) {
        clienteService.saveOrUpdate(cliente);
        return cliente.getId();
    }

}
