# Sistema de Gestión de Inventario y Trazabilidad de Insumos Médicos

## Integrantes del Grupo
A continuación se detallan los miembros del equipo de desarrollo, junto con el rol estratégico y operativo desempeñado a lo largo del ciclo de vida del proyecto:

| Integrante | Rol en el Proyecto | Responsabilidades Clave |
| :--- | :--- | :--- |
| **Levi Ramos** | Product Owner / DevOps Engineer | Gestión del ciclo de vida en GitHub, inicialización del entorno, integración continua, seguridad de accesos y resolución de excepciones globales. |
| **Katherine Álvarez** | Scrum Master / UI-UX Developer | Moderación de ceremonias ágiles, diseño de interfaces responsivas, interacción de catálogos y maquetación de componentes del Dashboard principal. |
| **Daniel Martínez** | Backend Developer / Database Administrator | Diseño del esquema relacional de la base de datos, optimización de consultas, control de lotes y lógica transaccional de movimientos de inventario. |
| **Ángel Mercado** | Backend Developer / QA Engineer | Implementación del motor matemático de alertas, generación y exportación de reportes operativos a PDF y diseño de pruebas de validación. |

---

## Tecnologías de Desarrollo
Para garantizar la escalabilidad, modularidad y seguridad exigidas por el entorno hospitalario, se seleccionó el siguiente stack tecnológico:

* **Lenguaje de Programación:** PHP 8.2.12
* **Framework de Desarrollo:** Laravel 12.58.0 (Arquitectura MVC y motor de plantillas Blade)
* **Gestor de Base de Datos:** MySQL / SQL Server (Esquema relacional con integridad referencial estricta)
* **Estilizado y UI:** Bootstrap 5 (Estructura responsiva basada en flexbox)
* **Control de Versiones:** Git & GitHub

---

## Metodología Ágil Seleccionada
Para el desarrollo de este proyecto se implementó la metodología **Scrum**. Esta elección permitió mitigar la incertidumbre a través de inspecciones periódicas y adaptaciones inmediatas.

### Enfoque Ágil y Flexibilidad del Flujo
El flujo de trabajo se estructuró en ciclos iterativos de incremento rápido de software (**Sprints semanales**). Fieles a los valores del manifiesto ágil sobre la adaptabilidad frente al seguimiento de un plan rígido, el flujo del tablero de tareas se diseñó con un enfoque flexible:

1.  **Backlog:** Repositorio centralizado de requerimientos funcionales y no funcionales desglosados.
2.  **To Do:** Tareas priorizadas listas para el inicio del ciclo operativo.
3.  **In Progress:** Actividades en desarrollo activo por parte del equipo.
4.  **Review / Testing:** Fase crítica de aseguramiento de la calidad y revisión de código mediante *Pull Requests*. Si se detectaba un error, inconsistencia o fallo de validación en esta etapa, **la metodología permitía retornar la tarea de forma transparente a la columna anterior (In Progress)** para su respectiva corrección, asegurando que ningún código con fallos avanzara a producción.
5.  **Done:** Criterio de terminado (DoD) cumplido al 100% y fusionado en la rama principal.

---

## Gestión de Requerimientos y Planificación de Sprints
Todos los requerimientos funcionales e ingenieriles se tradujeron directamente en el tablero de gestión bajo la estructura de **Historias de Usuario (con formato Connextra: *Como, Quiero, Para*), Tareas Técnicas y Bugs**. 

La carga de trabajo se distribuyó de manera equivalente mediante la estimación en **Story Points** (basada en la escala de Fibonacci), dividiendo el proyecto en 5 Sprints estratégicos:

* **Sprint 1 (Arranque y Alertas):** Inicialización del entorno Laravel, modelado inicial de la base de datos y despliegue del controlador de alertas automáticas utilizando funciones nativas del lenguaje (`now()`) para asegurar un código eficiente y de bajo acoplamiento.
* **Sprint 2 (Insumos y Lotes):** Desarrollo del núcleo transaccional mediante APIs de catálogos secundarios y la estructura relacional para ligar insumos, proveedores, lotes y movimientos de entrada/salida.
* **Sprint 3 (UI y Conflictos):** Conexión de datos en el frontend, corrección y estabilización de datos de prueba (*seeders*) e integración de campos de estado dinámicos.
* **Sprint 4 (Reportes y Seguridad):** Construcción del módulo de reportes con filtros avanzados y exportación a PDF, junto con la gestión de seguridad de accesos y roles (resolviendo de raíz excepciones de control de guards mediante Spatie).
* **Sprint 5 (Dashboard y Cierre):** Maquetación de la analítica del Dashboard basada en perfiles de usuario y depuración final de relaciones de integridad de llaves foráneas (`ubicacion_id`).

---

## Cultura DevOps e Integración Continua (CI)
El repositorio refleja una cultura de colaboración e ingeniería de software madura, caracterizada por:

* **Historial de Trabajo Sostenido:** Un flujo de desarrollo continuo y distribuido con un historial de cambios que supera de forma holgada las **2 semanas mínimas de trabajo exigidas**, evidenciando constancia diaria y descartando cargas masivas de última hora.
* **Estrategia de Ramas (GitFlow Adaptado):** Aislamiento de características mediante ramas de desarrollo (*feature branches*), lo que propició revisiones de código cruzadas y la resolución sistemática de conflictos de combinación (*merge conflicts*) antes de impactar la rama principal de producción.
