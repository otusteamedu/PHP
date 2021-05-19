Before:
One God class that create sql query, fetches data and formats it in one method.
This class obviously breaks Single Responsibility Principle.

After:
I created many classes to separate tasks: repository fetches data, formatter formats it.
I type hint through interfaces to depend on abstraction (Dependency Inversion), not specific realization.