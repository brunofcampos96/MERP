package com.controller;

import java.util.List;

import com.service.AbstractService;
import com.entity.IEntity;

public class AbstractController implements IController {
    AbstractService service;
    
    private List<IEntity> getAll() {
        return service.getAll();
    }

    private IEntity get(Long id) {
        return service.getById(id);
    }

    private void delete(Long id) {
        service.delete(id);
    }

    private Long save(Entity client) {
        service.saveOrUpdate(client);
        return client.getId();
    }
}
