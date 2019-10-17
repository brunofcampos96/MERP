package com.controller;

import com.data.IEntity;

public interface IController {
    private List<IEntity> getAll();

    private IEntity get(Long id);

    private void delete(Long id);

    private Long save(IEntity client);
}