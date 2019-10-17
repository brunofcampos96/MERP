package com.repository;
import org.springframework.data.repository.CrudRepository;
import org.springframework.stereotype.Repository;

import com.entity.ConsultorioEntity;

@Repository
public interface ConsultorioRepository extends CrudRepository<ConsultorioEntity, Long>{

}