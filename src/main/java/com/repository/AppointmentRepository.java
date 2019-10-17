package com.repository;
import org.springframework.data.repository.CrudRepository;
import org.springframework.stereotype.Repository;

import com.Entity.AppointmentEntity;

@Repository
public interface AppointmentRepository extends CrudRepository<AppointmentEntity, Long>{

}