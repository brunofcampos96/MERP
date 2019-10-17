package com.entity;

import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;

@Entity
public class AnamnesisEntity implements IEntity {
    @Id
    @GeneratedValue
    private Long id;

    public Long getId(){
        return id;
    }
}